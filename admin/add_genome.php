<?php

require("../include/clusterizator.php");
require("include/database.php");
require("include/job.php");

function check_code($tocheck) {
  global $dbh;
  // Check if code is already used
  $query=sprintf("SELECT COUNT(*) FROM genomes WHERE code=%s",
		 $dbh -> quote($tocheck));
  $result=$dbh->query($query);
  if ($result->fetchColumn() != 0)
    return FALSE;
  return TRUE;
}

// Main
clus_head();

if($_FILES["position"]["size"] != 0) {
   if ($_FILES["position"]["error"] > 0) {
      echo "Return Code: " . $_FILES["position"]["error"] . "<br />";
   } else if ($_FILES["position"]["size"] < 1024*1024) {
      if ($_POST["code"] === "") {
         exec ("mktemp -d data/genomes/XXXXXXXX", $tmparray );
         $dir = $tmparray[0];
         chmod($dir, 0770);
         move_uploaded_file($_FILES["position"]["tmp_name"],
                            $dir . "/" . "position.txt");
         $code = end(explode("/", $dir));
      } else {
         $code = $_POST["code"];
         if(!ctype_alnum($code)) {
            echo "Code should contain only alphanumeric characters";
            echo "<FORM><INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\"";
            echo " ONCLICK=\"history.go(-1)\">";
            echo "</FORM>";
	    clus_end();
            exit(0);
	 }
         if (!check_code($code)) {
            echo "Code already in use";
            echo "<FORM><INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\"";
            echo " ONCLICK=\"history.go(-1)\">";
            echo "</FORM>";
	    clus_end();
            exit(0);
         }

         $code = $_POST["code"];
         $dir = "data/genomes/" . $code;
         mkdir ($dir, 0770);
         move_uploaded_file($_FILES["position"]["tmp_name"],
                            $dir . "/" . "position.txt");
      }

      // Start randomizations jobs
      // $jid = start_job("randomizzatore/pval-table.sh " . $dir . " 10000",
      //                  $dir . "/jobout.txt", $dir . "/joberr.txt");

      $query=sprintf("INSERT INTO genomes (code, directory) VALUES (%s, %s)",
		     $dbh->quote($code),
		     $dbh->quote($dir));

      if ($dbh->exec($query) === FALSE) {
	echo "internal error, couldn't add genome <br />";
	print_r($_POST);
	echo '<br />';
      }

      $query=sprintf("SELECT rec_id FROM genomes WHERE code=%s",
		     $dbh->quote($code));
      $result=$dbh->query($query);
      $id = $result->fetchColumn();

      echo "Added genome with code " . $code . " and directory " . $dir;
      echo "<br />";
      echo "<a href=\"../admin/genome.php?action=menu&id=" . $id . "\">";
      echo "Open this genome</a>";
      echo "<br />";
      echo "<a href=\"tables.php\">";
      echo "Go back to tables administration</a>";

   }

} else {
   echo "Filename field cannot be void and/or cannot contain a void file";
   echo "<FORM><INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\"";
   echo " ONCLICK=\"history.go(-1)\">";
   echo "</FORM>";
}

clus_end();

?>
