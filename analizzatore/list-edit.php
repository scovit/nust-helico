<?php

require("../include/clusterizator.php");
require("include/menu.php");
require("include/database.php");
require("include/info.php");
require("include/list-work.php");
requirejs("include/list-edit.js");

if (isset($_GET["id"]))
    $info = list_load_info($_GET["id"]);
else if (isset($_GET["code"]) && isset($_GET["user"]))
    $info = list_load_info_code($_GET["code"], $_GET['user']);
else {
    exit(0);
}

clus_head();
export_list_info_js($info);
show_menu();

?>

<span class="list-owner">
<h1> Update information for the data set </h1>
Data set with code: <span class="prnt_lcode"></span><br />

<form class="template-href" action="../admin/list-queries.php?action=update&code=@@prnt_lcode@@&user=@@prnt_luser@@" method="post" enctype="multipart/form-data">
  <input id="titolo" type="text"  size=40 maxlength=128 name="title" />
  <input type="submit" value="Update name (max 128 char)">
</form>

<form class="template-href" action="../admin/list-queries.php?action=update&code=@@prnt_lcode@@&user=@@prnt_luser@@" method="post" enctype="multipart/form-data">
  <input id="directory" type="text"  size=40 maxlength=128 name="dir" />
  <input type="submit" value="Update directory (max 128 char)">
</form>


<form  class="template-href" action="../admin/list-queries.php?action=update&code=@@prnt_lcode@@&user=@@prnt_luser@@" method="post" enctype="multipart/form-data">
  <input type="file" name="readme" id="readme" />
  <input type="submit" value="Update readme file">
</form>

<form  class="template-href" action="../admin/list-queries.php?action=update&code=@@prnt_lcode@@&user=@@prnt_luser@@" method="post" enctype="multipart/form-data">
  <input type="file" name="original" id="original" />
  <input type="submit" name="submit" value="Update original data file">
</form>
</span>

<a  class="template-href" href="list.php?code=@@prnt_lcode@@&user=@@prnt_luser@@">
  Return to data set main page</a>
<br />

<?php
   clus_end();
?>
