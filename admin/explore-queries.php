<?php

require("../include/clusterizator.php");
require("include/database.php");
require("include/info.php");
require("include/rrmdir.php");

function query_lists($user) {
  global $dbh;
  global $session;


   $query="SELECT users.user, lists.code, lists.title, genomes.code, lists.dir, lists.sid FROM lists INNER JOIN genomes ON lists.genome = genomes.rec_id INNER JOIN users ON lists.user_id = users.rec_id WHERE 0";

   foreach ($user as $u) {
     if ($u === "guest")
       $query .= sprintf(' OR (users.user = %s AND lists.sid = %s)',
			 $dbh->quote($u), $dbh->quote($session['sid']));
     else
       $query .= sprintf(' OR users.user = %s', $dbh->quote($u));
   }

   $query .= " ORDER BY users.user, lists.dir, lists.title";
   return $dbh->query($query);
}

function print_lists($user) {
    $result = query_lists($user);
    while($row = $result->fetch(PDO::FETCH_NUM)) {
	echo "{$row[0]}&{$row[1]}&{$row[2]}&{$row[3]}&{$row[4]}\n";
    }
}

function print_genomes() {
  global $dbh;
  $query = "SELECT code, title FROM genomes";
  
  $result = $dbh->query($query);
  while($row = $result->fetch(PDO::FETCH_NUM)) {
    echo "{$row[0]}&{$row[1]}\n";
  }
}


if (!isset($_GET["action"]))
    $action="unknown";
else
    $action=$_GET["action"];

switch ($action) {
case "showlists":
    if (!isset($_GET["user"])) {
	echo "&error 2";
	break;
    }
    $user=$_GET["user"];
    if(!is_array($user)) {
	$temp = $user;
	unset($user);
	$user = array($temp);
    }
    $user = array_filter($user);
    if (can_get_list($user)) {
	print_lists($user);
        echo "&end";
    } else {
	echo "&error 3";
    }
    break;
case "showgenomes":
    print_genomes();
    echo "&end";
    break;
case "showlistsandgenomes":
    if (!isset($_GET["user"])) {
	echo "&error 2";
	break;
    }
    $user=$_GET["user"];
    if(!is_array($user)) {
	$temp = $user;
	unset($user);
	$user = array($temp);
    }
    $user = array_filter($user);
    if (can_get_list($user)) {
        echo "&lists\n";
	print_lists($user);
        echo "&genomes\n";
        print_genomes();
        echo "&end";
    } else {
	echo "&error 3";
    }
    break;
case "delete":
    if (!isset($_GET["user"])) {
	echo "&error 2";
	break;
    }
    $user=$_GET["user"];
    if (!isset($_GET["deletel"])) {
	echo "&error 2";
	break;
    }
    $err = delete_lists($_GET['deletel'], $user);
    if ($err) {
	echo "&error {$err}";
    } else
	echo "&end";

    break;
default:
    echo "&error 1";
}
