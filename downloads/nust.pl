#!/usr/bin/env perl

# NuST.pl
#
# description: This perl script is an example of how the NuST web
# server can be accessed systematically to upload data, perform
# analyses and download results. 
# usage:
# ./nust.pl dataset
#
# dataset is a gene list as a single-column text file 
#

# Create a user agent object
use LWP::UserAgent;
use HTTP::Cookies;
use HTTP::Request;
use HTTP::Request::Common qw(POST);
use HTTP::Request::Common qw(GET);
$ua = LWP::UserAgent->new;

# The NuST website
$nust = 'http://www.lgm.upmc.fr/nust';

# A cookie jar is necessary, the uploaded lists will be strictly
# accessible only to the users that provide the right access cookie
# In order to work on a dataset with multiple scripts
# it is possible to load and save the session cookie from a file
# with something like this
#
#   my $cookie_jar = HTTP::Cookies->new(
#      file     => "/some/where/cookies.lwp",
#      autosave => 1,
#   );
#
# instead of creating a new cookie jar

# Create a new cookie jar
my $cookie_jar = HTTP::Cookies->new();
$ua->cookie_jar($cookie_jar);

#
# The following part of the code uploads a gene list to the current
# session, and prints user and the code of the uploaded list
#

my $req = POST $nust . '/analizzatore/add_list.php',
    Content_Type => 'form-data',
    Content => [
	user => 'guest',
	genome => 'K12',
	list => [$ARGV[0], 
		 "Content-Type" => "plain/text"]
    ];

# Pass request to the user agent and get a response back
my $res = $ua->request($req);

# Check the outcome of the response
if (!$res->is_success) {
    print $res->status_line, "\n";
    exit;
}

# Parse the response
my $retval = 0;
my $user = "";
my $code = "";
print $res->content;
foreach(split('\n',$res->content)){
    my($line) = $_;
    my @fields = ();
    if ($line =~ "parent.doneUpload") {
	@fields = split(', ',$line);
	$retval = (split(/\(/, $fields[0]))[1];
	$user = $fields[2];
	$code = $fields[1];
	$user =~ s/^\"//;
	$user =~ s/\"\);$//;
        $code =~ s/^\"//;
	$code =~ s/\"$//;
    }
}

if ($retval != 100) {
    print "Error uploading list\n";
    exit;
}

print "Uploaded list with code ", $code, " to user ", $user, "\n";

#
# The following part of the code starts a cluster analysis,
# The program  checks if the results are ready
#
my $clures = ();
do {
# Checking for availability, the first time you do this check, it also
# starts the cluster analysis
    my $clureq = GET $nust . '/admin/cluster-queries.php' . 
	'?action=available' .
	'&code=' . $code. '&user=' . $user;

# Pass request to the user agent and get a response back
    $clures = $ua->request($clureq);
    
# Check the outcome of the response
    if (!$clures->is_success) {
	print $clures->status_line, "\n";
	exit;
    }
    
# Parse the response
    if($clures->content =~ "&synon") {
	print "The list contain some unrecognized genes, maybe there exist";
	print " a valid synonim on our database. You can dowload the synonim";
	print " database from the web at " . $nust . "/downloads.php";
	print "\n";
    }

    print "The script will now sleep and check every 10 seconds waiting ";
    print "for the results to be available\n";
    sleep(10);
} while ($clures->content =~ "&waiting");

if (!($clures->content =~ "&available")) {
    print "An error occoured doing the analysis\n";
    exit;
}

#
# In order to download the results of the cluster analysis
# you can use the script located in /admin/cluster-queries.php
#
# set 
#      ?action=getcircular  to get the cluster founds
#      ?action=getresults   to get the linear aggregation analysis
#      &format=txt          for text output
#      &format=png          for png output
#      &format=pdf          for pdf output
#      &format=svg          for svg output
#      &format=agr          for grace output
#   note: not all format are available as output for every analysis
#         check the website for the different output formats
#
# To do a local pearson correlation you can use the script located at
# /admin/sliding-queries.php?action=getpearson&format=pdf
# &code[]=PPWlBFwI&user[]=common&code[]=Die38UKs&user[]=common&bins=64
# by putting the "user" and "code" of the two list you want to compare,
# the number of bins and the output format
#
# To do a multiple sliding window histogram you can use the script located at
# /admin/sliding-queries.php?action=getsliding&format=pdf
# &code[]=yDur2GFT&user[]=common&code[]=B3LmwbWJ&user[]=common
# &code[]=ksHioq3J&user[]=common&code[]=oRSLElJu&user[]=common
# &bins=64&normalize=true
# by putting the "user" and "code" of the multiple lists you want to compare,
# the number of bins and if you want the results normalized or not
#
# Download the clusters for bins 32 -> 128
#
my $bin1 = 32;
my $bin2 = 128;
my $diareq = GET $nust . '/admin/cluster-queries.php' .
    "?action=getcircular" .
    "&code=" . $code . "&user=" . $user . "&format=txt".
    "&bins1=" . $bin1 ."&bins2=" . $bin2;

# Pass request to the user agent and get a response back
$diares = $ua->request($diareq);
    
# Check the outcome of the response
if (!$diares->is_success) {
    print $diares->status_line, "\n";
    exit;
}

# Save the response to a file
open FILE, ">circularoutput.txt" or die $!;
print FILE $diares->content;
close FILE;

print "Results saved in file circularoutput.txt\n";
