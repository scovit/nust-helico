<?php

require("../include/clusterizator.php");
require("include/database.php");
require("include/info.php");
require("include/rrmdir.php");

// this will erase all session older than one week each week
function clear_old_sessions() {
  global $dbh;
  $lockfile="data/sessions.lock";
  // do it only once in a while
  if (file_exists($lockfile) && 
      (filemtime($lockfile) > (time() - 604800)))
    return;
  touch($lockfile);


  if ($handle = opendir("data/sessions/")) {
    while (false !== ($file = readdir($handle))) {
      if ($file != "." && $file != "..") {
	$stemp = unserialize(file_get_contents("data/sessions/" . $file));
	if (($stemp['user'] === 'guest') &&
	    ($stemp['timestamp'] < (time() - 604800))) {
	  $query=sprintf("SELECT directory FROM lists
                          WHERE user_id=2 AND sid=%s",
			 $dbh->quote($stemp['sid']));
	  $result=$dbh->query($query);
	  if($result == FALSE) {
	    return -1;
	  }

	  while($row = $result->fetchColumn()) {
	    rrmdir($row);
	  }

	  $query=sprintf("DELETE FROM lists
                          WHERE user_id=2 AND
                          sid=%s",
			 $dbh->quote($stemp['sid']));
	  if($dbh->exec($query) === FALSE) {
	    return -2;
	  }
	  //	  unlink ("data/sessions/" . $file);

	}
      }
    }
    closedir($handle);
  }

}

function check_code($tocheck, $user) {
  global $dbh;
  // Check if code is already used
  $query = sprintf('SELECT COUNT(*) FROM lists INNER JOIN users on users.rec_id=lists.user_id where lists.code=%s and users.user=%s',
		   $dbh->quote($tocheck),
		   $dbh->quote($user));
  $result=$dbh->query($query);
  if ($result->fetchColumn() != 0)
    return FALSE;
  return TRUE;
}

function list_file_euristics($filename) {
  $lines = file($filename);
  for($i = 0; $i<count($lines); $i++)
    $lines[$i] = strtr(trim($lines[$i]), "&", "_");
  file_put_contents($filename, implode("\n", array_filter($lines)) . "\n");
}

clus_head();

if($_FILES["list"]["size"] != 0) {
   if ($_FILES["list"]["error"] > 0) {
       echo <<<EOF
	   <script language="javascript" type="text/javascript">
	   parent.doneUpload({$_FILES["list"]["error"]});
       </script>
EOF;
   } else if ($_FILES["list"]["size"] < 1024*1024) {
       $genome = $_POST["genome"];
       $user = $_POST["user"];
       if(!isset($_POST["title"]) || $_POST["title"] === "")
	 $title = "No title";
       else
	 $title = $_POST["title"];

       if($user === "guest")
	 clear_old_sessions();
       
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
	     clus_end();
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
	 if (isset($_FILES['readme']))
	   exec("fromdos {$_FILES['readme']['tmp_name']}");
 	 exec("fromdos {$_FILES['list']['tmp_name']}");
         move_uploaded_file($_FILES["list"]["tmp_name"],
                            $dir . "/" . "list.txt");
	 list_file_euristics($dir . "/" . "list.txt");
	 if (isset($_FILES['readme']))
	   move_uploaded_file($_FILES["readme"]["tmp_name"],
			      $dir . "/" . "readme.txt");
	 if (isset($_FILES['original']))
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
          clus_end();
	  exit(0);
      }

      $query=sprintf("SELECT COUNT(*) FROM lists
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
	  clus_end();
	  exit(0);
      }
      echo <<<EOF
	  <script language="javascript" type="text/javascript">
	  parent.doneUpload(100, "{$code}", "{$user}");
      </script>
EOF;
   } else {
       echo <<<EOF
	   <script language="javascript" type="text/javascript">
	   parent.doneUpload(-2);
       </script>
EOF;
   }

} else {
echo <<<EOF
<script language="javascript" type="text/javascript">
    parent.doneUpload(-1);
</script>
EOF;
}

clus_end();

?>

