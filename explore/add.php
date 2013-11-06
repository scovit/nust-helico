<?php
   require("../include/clusterizator.php");
   require("include/menu.php");
   require("include/explore-work.php");
   requirejs("include/explore-add.js");
   requirecss("include/explore.css");
   requirecss("include/sliding-iframe.css");
   requirejs("include/sliding-iframe.js");
   
   clus_head();
   show_menu();
   get_explore_info();
?>

Select an option:<br />

<a href="javascript:show_sliding_window('file-pers-slid');" >
  Load a data set of genes from file</a> 
<br />
<iframe src="add-file.php?username=@@prnt_exploreuser@@&iframe=true" id="file-pers-slid" class="sliding-hidden template-href">
</iframe>

<a href="javascript:show_sliding_window('inter-pers-slid');" >
  Create a data set from the intersection of multiple data sets</a> 
<br />
<iframe src="add-hyper.php?username=@@prnt_exploreuser@@&iframe=true" id="inter-pers-slid" class="sliding-hidden template-href">
</iframe>


<a href="javascript:show_sliding_window('merge-pers-slid');" >
  Create a data set from the merge of multiple data sets</a> 
<br />
<iframe src="add-merge.php?username=@@prnt_exploreuser@@&iframe=true" id="merge-pers-slid" class="sliding-hidden template-href">
</iframe>
