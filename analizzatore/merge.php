<?php

require("../include/clusterizator.php");
require("include/database.php");
require("include/info.php");

function check_code($tocheck, $user) {
  global $dbh;
  // Check if code is already used
  $query=sprintf("SELECT COUNT(*) FROM lists INNER JOIN users
                 ON users.rec_id=lists.user_id 
                 WHERE lists.code=%s AND users.user=%s",
		 $dbh -> quote($tocheck),
		 $dbh -> quote($user));
  $result=$dbh -> query($query);
  if ($result -> fetchColumn() != 0)
    return FALSE;
  return TRUE;
}

function get_merge($info1, $info2) {
    $genes1 = file($info1['ldir'] . "/list.txt",
		   FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $genes2 = file($info2['ldir'] . "/list.txt",
		   FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    return array_unique(array_merge($genes1, $genes2));
}
    

function create_list_from_merge($info1, $info2, $user) {
  global $dbh;
  global $session;
    $genes = get_merge($info1, $info2);

    $genome = $info1["gcode"];
    if(!isset($_POST["title"]) || $_POST["title"] === "")
      $title = "No title";
    else
      $title = $_POST["title"];
    
    $sessid = $session['sid'];

    if(!isset($_POST["dir"]) || $_POST["dir"] === "")
      $direc = "No directory";
    else
      $direc = $_POST["dir"];

    if (strpos ($title , "&") || strpos ($title , "\\") ||
	strpos ($title , "'") || strpos ($title , '"') ||
	strpos ($direc , "&") || strpos ($direc , "\\") ||
	strpos ($direc , "'") || strpos ($direc , '"')) {
      echo <<<EOF
	<script language="javascript" type="text/javascript">
	parent.doneUpload(-7);
      </script>
EOF;
      exit(0);
    }

    if(!can_modify_list($user)) {
	echo <<<EOF
	    <script language="javascript" type="text/javascript">
	    parent.doneUpload(-6);
	</script>
EOF;
	exit(0);
    }    

    $usrdir = "data/lists/{$user}";
    if (!is_dir($usrdir)) {
	mkdir ($usrdir);
	chmod($usrdir, 0770);
    }

    exec ("mktemp -d {$usrdir}/XXXXXXXX", $tmparray );
    $dir = $tmparray[0];
    $code = end(explode("/", $dir));
    chmod($dir, 0770);
    foreach ($genes as $k => $i)
      $genes[$k] .= "\n";
    file_put_contents($dir . "/" . "list.txt", $genes, LOCK_EX);
    exec("fromdos {$_FILES['readme']['tmp_name']}");
    move_uploaded_file($_FILES["readme"]["tmp_name"],
		       $dir . "/" . "readme.txt");
    move_uploaded_file($_FILES["original"]["tmp_name"],
		       $dir . "/" . "original.dat");

    
    $query = sprintf("
                      INSERT INTO lists
                        (code, directory, title, dir, genome, user_id, sid)
                      SELECT %s, %s, %s, %s,
                        genomes.rec_id,
                        users.rec_id,
                        %s
                      FROM genomes, users
                      WHERE genomes.code = %s
                      AND users.user = %s",
		     $dbh->quote($code),
		     $dbh->quote($dir),
		     $dbh->quote($title),
		     $dbh->quote($direc),
		     $dbh->quote($sessid),
		     $dbh->quote($genome),
		     $dbh->quote($user)
		     );
    
    if ($dbh->exec($query) != 1) {
      echo <<<EOF
	      <script language="javascript" type="text/javascript">
	      parent.doneUpload(-5);
	  </script>
EOF;
      exit(0);
    }

    $query=sprintf("SELECT COUNT(lists.rec_id) FROM lists
                    INNER JOIN users ON users.user=%s
                    WHERE code=%s",
		   $dbh->quote($user),
		   $dbh->quote($code));
    $result=$dbh->query($query);
    if ($result->fetchColumn() != 1) {
      echo <<<EOF
	      <script language="javascript" type="text/javascript">
	      parent.doneUpload(-5);
	  </script>
EOF;
      exit(0);
    }
    
    echo <<<EOF
      <script language="javascript" type="text/javascript">
      parent.doneUpload(101, "{$code}", "{$user}");
    </script>
EOF;
}


# Main
if (!isset($_REQUEST["user1"]) ||
    !isset($_REQUEST["list1"]) ||
    !isset($_REQUEST["user2"]) ||
    !isset($_REQUEST["list2"])) {
    echo "&error 2";
    exit(0);
}

$info1 = list_load_info_code($_REQUEST["list1"], $_REQUEST["user1"]);
$info2 = list_load_info_code($_REQUEST["list2"], $_REQUEST["user2"]);
if((!$info1) || (!$info2)) {
    echo "&error 3";
    exit(0);
}

if (!isset($_REQUEST["action"]))
    $action="unknown";
else
    $action=$_REQUEST["action"];

switch ($action) {
case "create":
    
    if(!isset($_POST["user"])) {
	echo "$error 4";
	break;
    }
    $user = $_POST["user"];
    if(!can_modify_list($user)) {
	echo <<<EOF
	    <script language="javascript" type="text/javascript">
	    parent.doneUpload(-6);
	</script>
EOF;
    }
    
    create_list_from_merge($info1, $info2, $user);

    break;
default:
    echo "&error 1";
}
