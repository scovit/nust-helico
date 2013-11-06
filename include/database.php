<?php
//$username="clusterizator";
//$password="cacca";
//$database="clusterizator";

//mysql_connect('localhost', $username, $password);
//@mysql_select_db($database) or die( "Unable to select database");

# We connect to the database
$dbfile="data/database.sqlite";
$dbschema="data/database.schema";
$dbh = null;
$updateschema = false;

try {
  if (!file_exists ($dbfile)) {
    touch($dbfile);
    chmod($dbfile, 0660);
    $dbh = new PDO('sqlite:' . $dbfile);
    $updateschema = true;
  } else {
    $dbh = new PDO('sqlite:' . $dbfile);
  }
}
catch (PDOException $e) {
  die("Unable to connect: " . $e -> getMessage());
}

$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($updateschema) {
  try {  
    $dbh->beginTransaction();
    $dbh->exec(file_get_contents($dbschema));
    $dbh->commit();
  } catch (Exception $e) {
    $dbh->rollBack();
    die("Failed: " . $e->getMessage());
  }
}


?>
