<?php
$rootdir="/var/www/nust";
$webdir="/nust";
chdir($rootdir);
$javascripts = NULL;
$csss = NULL;
$session = NULL;

function save_session_file() {
  global $session;
  global $rootdir;
  if(isset($session['sid']) && ($session['sid'] != "")) {
    $filename = $rootdir . "/data/sessions/" . $session['sid'];
    file_put_contents($filename,
		      serialize($session), LOCK_EX);
    chmod($filename, 0660);
  }
}

function set_the_cookie() {
  global $session;
  global $webdir;
  $tmpname = exec("mktemp data/sessions/XXXXXXXXXXXXXXXX");
  $sid = explode("/", $tmpname);
  $sid = $sid[2];
  // Set a cookie for the next 24 hours
  setcookie("nucleoidID", $sid, time()+86400, $webdir);
  $_COOKIE["nucleoidID"] = $sid;
  // Compile the basic session data
  $session = array(
		   'sid' => $sid,
		   'timestamp' => time(),
		   'ip' => $_SERVER['REMOTE_ADDR'],
		   'user' => 'guest',
		   'privilege' => 100
		   );
  
  // Save the data in the file
  save_session_file();
  return $sid;
}

function initialize_session() {
  global $session;
  // If there not a session, start a new one
  if (!isset($_COOKIE["nucleoidID"])) {
    $sid = set_the_cookie();
  } else {
    $sid = $_COOKIE["nucleoidID"];
  }

  // Load the basic session data
  if (file_exists("data/sessions/" . $sid))
    $session = unserialize(file_get_contents("data/sessions/" . $sid));

  // Set the data for saving at exit
  register_shutdown_function ('save_session_file');

  Header("Cache-control: private, no-cache");
  Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
  Header("Pragma: no-cache");
}

function destroy_session() {
  global $webdir;
  setcookie("nucleoidID", "", time()-3600, $webdir);
}

initialize_session();

function requirejs($js) {
  global $javascripts;
  $javascripts[] = $js;
}

function requirecss($css) {
  global $csss;
  $csss[] = $css;
}

requirecss("include/clusterizator.css");
requirejs("include/clusterizator.js");
requirejs("include/getElementsByClassName-1.0.1.js");

function islogged () {
  global $session;
  if (isset($session['privilege']) && ($session['privilege'] < 2))
    return TRUE;
  else
    return FALSE;
}

function isadmin () {
  global $session;
  if (isset($session['privilege']) && ($session['privilege'] == 0))
    return TRUE;
  else
    return FALSE;
}

function clus_head() {
    global $webdir;
    global $javascripts;
    global $csss;
    global $session;

    /* // beta testing */
    /* if(!islogged()) { */
    /*   $javascripts = NULL; */
    /*   $csss = NULL; */
    /*   requirecss("include/clusterizator.css"); */
    /*   requirejs("include/clusterizator.js"); */
    /*   requirejs("include/getElementsByClassName-1.0.1.js"); */
    /*   requirecss("include/menu.css"); */
    /*   requirejs("include/menu.js"); */
    /* } */
    
    echo <<<EOF
	<!DOCTYPE HTML>
	<html>
	<head>
	<link rel="SHORTCUT ICON" href="{$webdir}/images/clusterizator.ico"/>
	<meta name="keywords" content="cluster, clustering, data analysis, nucleoid, bacteria, E. coli, chromosome, tool, biology, bioinformatics" />
	<meta name="description" content="Database Tool for analyzing the spatial distribution of gene sets and extracting statistically significant linear aggregation clusters" />
	<meta name="author" content="Vittore Scolari" />
	<meta name="copyright" content="Copyright © 2011 UPMC" />
	<title>NuST@"Genomique des Microorganismes,
                UMR 7238 CNRS - Universite Pierre et Marie Curie"</title>

EOF;

    if (isset($javascripts)) {
	foreach ($javascripts as $js) {
	    echo "      <script type=\"text/javascript\" src=\"{$webdir}/{$js}\"></script>\n";
	}
    }

    if (isset($csss)) {
	foreach ($csss as $css) {
	    echo "      <link rel=\"stylesheet\" type=\"text/css\" href=\"{$webdir}/{$css}\" />\n";
	}
    }
    
    echo <<<EOF

	</head>
	<body>
	<span id="webdir" class="hidden">{$webdir}</span>
	<span id="user" class="hidden">{$session['user']}</span>
        <div id="custerizatorcontent">

EOF;

    /* // beta testing */
    /* if (!islogged()) { */
    /*   show_menu(); */
    /*   $toshow ="<p>This website is in manteinance, it will not work right now!!</p><p>This web-site is in beta-testing, you should login with a valid username and password in order to use it.</p><br /><br />"; */
    /*   $toshow .="<img class=\"center\" src=\"{$webdir}/images/no_ie.gif\" /><br />Not tested on Microsoft Internet Explorer, please use Mozilla Firefox or Google Chrome instead."; */
    /*   echo $toshow; */
    /*   clus_tail(); */
    /*   exit(0); */
    /* } */

}

function clus_end() {
  //  global $session;
  //  echo "</br></br>";
  //  print_r($session);
  //  echo "</br>";
  //  print_r($_COOKIE);
echo <<<EOF
    </div>
    </body>
    </html>
EOF;
}

function clus_tail() {
    clus_end();
}

?>