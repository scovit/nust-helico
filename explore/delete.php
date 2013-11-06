<?php
   require("../include/clusterizator.php");
   require("include/menu.php");
   require("include/explore-work.php");
   requirejs("include/explore-delete.js");
   requirecss("include/explore.css");
   
   clus_head();
   show_menu();
   get_explore_info();
?>


Select the data sets that you want to delete and then click on "Delete"<br /><br />
<form id="form-c-del-pers-split" method="get" action="javascript:void(0)" onsubmit='delete_lists(event)'>
  <div id="deletecontent">
  </div>
  <input id="subbutton" type="submit" value="Delete">
</form>
