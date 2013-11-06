<?php

function delete_record_and_dir($delete_array, $table) {
  global $dbh;
  // Delete the directories
  $query=sprintf("SELECT directory FROM %s WHERE 0",
		 $dbh->quote($table));
   for ($i = 0; $i < count($delete_array); $i++)
     $query .= sprintf(" OR rec_id=%s",
		       $dbh->quote($delete_array[$i]));

   $result = $dbh->query($query);
   if($result === FALSE) {
      echo "internal error, could not delete " . $table;
      echo " on database". '<br />';
      print_r($_GET);
      echo '<br />';
   }

   while($row = $result->fetch(PDO::FETCH_NUM))
     rrmdir($row[0]);

   //  Expunge the records from the database
   $query=sprintf("DELETE FROM %s WHERE 0",
		  $dbh -> quote($table));
     
   for ($i = 0; $i < count($delete_array); $i++)
     $query .= sprintf(" OR rec_id=%s",
		       $dbh->quote($delete_array[$i]));

   if($dbh -> exec($query) === FALSE) {
     echo "internal error, couldn't delete " . $table;
      echo " on database". '<br />';
      print_r($_GET);
      echo '<br />';
   }
}

function table_lists() {
  global $dbh;
  $query="SELECT lists.*, genomes.code FROM lists INNER JOIN genomes ON lists.genome = genomes.rec_id";
  $result=$dbh->query($query);
  
  echo "<form name=\"delete_list\" action=\"tables.php\" method=\"post\">\n";
  
  while($row = $result->fetch(PDO::FETCH_NAMED)) {
    echo "<input type=\"checkbox\" name=\"deletel[]\" value=\"" .
      $row['rec_id'] .
      "\" />";
    echo "<a href=\"../analizzatore/list_old.php?action=menu&id=" .
      $row['rec_id'] .
      "\">";
    echo $row['rec_id'] . " - " . $row['code'][0] . " - " .
      $row['directory'] . " - " . $row['genome'] . " - " .
      $row['code'][1];
    echo '</a><br />';
    echo "\n";
  }
}

?>
