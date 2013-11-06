<?php
   require("../include/clusterizator.php");
   require("include/menu.php");
   require("include/explore-work.php");
   requirejs("include/explore-analize.js");
   requirecss("include/explore.css");
   
   clus_head();
   show_menu();
   get_explore_info();
?>

Click on the data set that you want to analyze<br /><br />
<div id="analizecontent">
</div>

