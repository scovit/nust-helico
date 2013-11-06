<?php

function rrmdir($dir) {
   if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
         if ($object != "." && $object != "..") {
           if (filetype($dir."/".$object) == "dir") 
              rrmdir($dir."/".$object);
           else
              unlink($dir."/".$object);
         }
      }
      reset($objects);
      rmdir($dir);
   }
} 

function delete_lists($delete_array, $user) {
  global $dbh;
  
  // Delete the directories
  $query=sprintf("SELECT lists.directory, users.user FROM lists
                  INNER JOIN users ON lists.user_id = users.rec_id
                  WHERE users.user=%s AND (0",
		 $dbh->quote($user));
  for ($i = 0; $i < count($delete_array); $i++) {
    if ($u === "guest")
      $query .= sprintf(' OR (lists.code=%s AND lists.sid = %s)',
			$dbh->quote($delete_array[$i]),
			$dbh->quote($session['sid']));
    else
      $query .= sprintf(" OR lists.code=%s",
			$dbh->quote($delete_array[$i]));
  }
  $query .= ")";
  
  $result=$dbh->query($query);
  if($result == FALSE) {
    return -1;
  }

  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $dir=$row["directory"];
    $user=$row["user"];
    // check for permissions
    if(!can_modify_list($user))
      return -3;
    
    rrmdir($dir);
  }

  // Expunge the records from the database
  $query=sprintf("DELETE FROM lists
                  WHERE user_id IN (
                     SELECT rec_id FROM users WHERE users.user=%s
                  ) AND (0",
		 $dbh->quote($user));
  for ($i = 0; $i < count($delete_array); $i++) {
    $query .= sprintf(" OR lists.code=%s",
		      $dbh->quote($delete_array[$i]));
  }
  $query .= ")";

   if($dbh->exec($query) === FALSE) {
       return -4;
   }

   return 0;
}



?>
