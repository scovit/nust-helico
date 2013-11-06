<?php

require("../include/clusterizator.php");
require("include/database.php");
require("include/downfile.php");
require("include/info.php");
require("include/rrmdir.php");
require("include/menu.php");

function update($info) {
  global $dbh;
  if(!can_modify_list($info['luser'])) {
    echo "You do not have the privileges to upload files on this dataset";
    exit(0);
  }

  if (isset($_FILES["readme"]))
    exec("fromdos {$_FILES['readme']['tmp_name']}");
    move_uploaded_file($_FILES["readme"]["tmp_name"],
		       $info["ldir"] . "/readme.txt");
  if (isset($_FILES["original"]))
    move_uploaded_file($_FILES["original"]["tmp_name"],
		       $info["ldir"] . "/original.dat");

  if (isset($_POST["title"])) {
    $query=sprintf("UPDATE lists SET title=%s WHERE rec_id=%u",
		   $dbh -> quote($_POST['title']),
		   $info['lid']);
    
    if($dbh -> exec($query) != 1) {
      echo "internal error, could not update list on database". '<br />';
      echo '<br />';
      exit(0);
    }
  }
  
  if (isset($_POST["dir"])) {
    $query=sprintf("UPDATE lists SET dir=%s WHERE rec_id=%u",
		   $dbh -> quote($_POST['dir']),
		   $info['lid']);
    
    if($dbh -> exec($query) != 1) {
      echo "internal error, could not update list on database". '<br />';
      echo '<br />';
      exit(0);
    }
  }
}

function delete_list($info) {
  global $dbh;
  if(!can_modify_list($info['luser'])) {
    echo "You do not have the privileges to delete this dataset";
    exit(0);
  }
  
  rrmdir($info["ldir"]);
  $query=sprintf("DELETE FROM lists WHERE rec_id=%u", $info["lid"]);
  
  if($dbh->exec($query) != 1) {
    echo "internal error, could not delete list on database". '<br />';
    echo '<br />';
  }
}

if (isset($_GET["id"]))
  $info = list_load_info($_GET["id"]);
else if (isset($_GET["code"]) && isset($_GET["user"]))
  $info = list_load_info_code($_GET["code"], $_GET['user']);
else {
  exit(0);
}

if (!isset($_GET["action"]))
    $action="unknown";
else
    $action=$_GET["action"];

switch ($action) {
case "getinfo":
  echo "lcode" . "&" . $info["lcode"] . "\n";
  echo "luid" . "&" . $info["luid"] . "\n";
  echo "luser" . "&" . $info["luser"] . "\n";
  echo "ltitle" . "&" . $info["ltitle"] . "\n";
  echo "ldirec" . "&" . $info["ldirec"] . "\n";
  echo "gcode" . "&" . $info["gcode"] . "\n";
  echo "ljob" . "&" . $info["ljob"] . "\n";
  echo "gjob" . "&" . $info["gjob"] . "\n";
  break;
			  
case "ownership":
  if (can_modify_list($info["luser"]))
    echo "&true";
  else
    echo "&false";
  break;

case "showlist":
  downfile($info["ldir"] . "/list.txt", "t");
  break;

case "showreadme":
  downfile($info["ldir"] . "/readme.txt", "t");
  break;

case "downorig":
  downfile($info["ldir"] . "/original.dat");
  break;

case "update":
  update($info);
  header("Location: ../analizzatore/list.php?code={$info['lcode']}&user={$info['luser']}");
  break;

case "delete":
  delete_list($info);
  clus_head();
  show_menu();
  echo "List with code " . $info["lcode"];
  echo " deleted<br />";
  echo "<a href=\"..\">";
  echo "Go to main page</a>";
  clus_end();
  break;

default:
  echo "&error 1";
}
