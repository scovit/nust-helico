<?php

require("../include/clusterizator.php");
require("include/database.php");
require("include/downfile.php");
require("include/info.php");
require("include/rrmdir.php");
require("include/menu.php");

function delete_genome($info) {
  global $dbh;
  rrmdir($info["gdir"]);
  $query=sprintf("DELETE FROM genomes WHERE rec_id=%u", $info["gid"]);

  if($dbh -> exec($query) === FALSE) {
    echo "internal error, could not delete genome from database". '<br />';
    echo '<br />';
  }
}

function upload_files($info) {
         move_uploaded_file($_FILES["readme"]["tmp_name"],
                            $info["gdir"] . "/readme.txt");
         move_uploaded_file($_FILES["synonim"]["tmp_name"],
                            $info["gdir"] . "/synonim.txt");
}

function show_info_and_menu($info) {
    echo "<h1> Informations </h1>";
    echo "This is genome number: <i>" . $info["gid"] . "</i><br />";
    echo "it has code: <i>" . $info["gcode"] . "</i><br /><br />";

    echo "<h1> Select an option </h1>";

    // if present, otherwise an option to add it
    echo "<a href=\"genome.php?action=showposition&id=" . $info["gid"] . "\">";
    echo "Show position</a>";
    echo "<br />";

    if (file_exists($info["gdir"] . "/readme.txt")) {
	echo "<a href=\"genome.php?action=showreadme&id=" . $info["gid"] . "\">";
	echo "Show readme file</a>";
	echo "<br />";
    } else {
	echo "Show readme file (readme not found)";
	echo "<br />";
    }

    if (file_exists($info["gdir"] . "/synonim.txt")) {
	echo "<a href=\"genome.php?action=showsynonim&id=" . $info["gid"] . "\">";
	echo "Show synonym file</a>";
	echo "<br />";
    } else {
	echo "Show synonym file (synonim file not found)";
	echo "<br />";
    }

    echo "<a href=\"../admin/tables.php?action=show&genome=" . $info["gid"] . "\">";
    echo "Show related datasets</a>";
    echo "<br />";

    echo "<a href=\"synon.php?type=genome&id=" . $info["gid"] . "\">";
    echo "Synonym tool</a>";
    echo "<br />";

    echo "<a href=\"genome.php?action=delete&id=" . $info["gid"] . "\">";
    echo "Delete this genome</a>";
    echo "<br /><br />";

    // Update file forms
    echo "Update files<br />";

    echo "<form action=\"genome.php?action=update&id=" . $info["gid"];
    echo "\" method=\"post\" enctype=\"multipart/form-data\">";
    echo "<input type=\"file\" name=\"readme\" id=\"readme\" />";
    echo "<input type=\"submit\" name=\"submit\" value=\"";
    if (file_exists($info["gdir"] . "/readme.txt"))
        echo "Update readme file";
    else
	echo "Load a readme file";
    echo "\"/><br />";

    echo "<form action=\"genome.php?action=update&id=" . $info["gid"];
    echo "\" method=\"post\" enctype=\"multipart/form-data\">";
    echo "<input type=\"file\" name=\"synonim\" id=\"synonim\" />";
    echo "<input type=\"submit\" name=\"submit\" value=\"";
    if (file_exists($info["gdir"] . "/synonim.txt"))
        echo "Update synonym file";
    else
	echo "Load a synonym file";
    echo "\"/>";
    echo "<br /><br />";


    echo "<a href=\"..\">";
    echo "Go to main page</a>";
}

if (isadmin()) {

  // Main
if (isset($_GET["id"]))
    $info = genome_load_info($_GET["id"]);
else if (isset($_GET["code"]))
    $info = genome_load_info_code($_GET["code"]);
else {
    clus_head();
    show_menu();
    echo "Please refer to the genome you want to load";
    echo " with a valid id or code field";
    echo "<FORM><INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\"";
    echo " ONCLICK=\"history.go(-1)\">";
    echo "</FORM>";
    clus_end();
    exit(0);
}

if (!isset($_GET["action"]))
    $action="unknown";
else
    $action=$_GET["action"];

switch ($action) {
    case "showposition":
	downfile($info["gdir"] . "/position.txt");
        break;
    case "showreadme":
	downfile($info["gdir"] . "/readme.txt");
        break;
    case "showsynonim":
	downfile($info["gdir"] . "/synonim.txt");
        break;
    case "update":
	upload_files($info);
        header("Location: genome.php?action=menu&id=" . $info["gid"]);
        break;
    case "delete":
	delete_genome($info);
        clus_head();
	show_menu();
        echo "Genome number " . $info["gid"] . " with code " . $info["gcode"];
        echo " deleted<br />";
        echo "<a href=\"..\">";
        echo "Go to main page</a>";
        clus_end();
        break;
    case "menu":
        clus_head();
	show_menu();
	show_info_and_menu($info);
        clus_end(); 
	break;
	
    default:
        clus_head();
	show_menu();
	echo "Please use an action field";
	echo "<FORM><INPUT TYPE=\"BUTTON\" VALUE=\"Go Back\"";
	echo " ONCLICK=\"history.go(-1)\">";
	echo "</FORM>";
        clus_end();
    exit(0);
}

}

?>

