<?php
   require("../include/clusterizator.php");
   require("include/menu.php");
   require("include/explore-work.php");
   requirecss("include/split-iframe.css");
   requirejs("include/split-iframe.js");
   requirejs("include/explore.v2.js");
   
   clus_head();
   show_menu();
   get_explore_info();
?>

<h1>Personal data sets</h1>

<!-- <span class="notlogged">If you login with a valid account, you can add and analyze your private data sets. -->
<!-- </span> -->

<!-- <span class="logged"> -->
  <div id="pers-split" class="split-window">
    <span id="ana-pers-split" class="split active-split">
      <a id="a-ana-pers-split" class="splitlink template-href"
	 href="analize.php?username=@@prnt_user@@&iframe=true">
	<img class="splitimg" src="../images/stock_task.png" />
	Analyze</a></span>
    <span id="add-pers-split" class="split">
      <a id="a-add-pers-split"  class="splitlink template-href"
	 href="add.php?username=@@prnt_user@@&iframe=true">
	<img class="splitimg" src="../images/stock_todo.png" />
	Add</a></span>
    <span id="del-pers-split" class="split">
      <a id="a-del-pers-split"  class="splitlink template-href"
	 href="delete.php?username=@@prnt_user@@&iframe=true">
	<img class="splitimg" src="../images/stock_minus.png" />
	Delete</a></span>

    <iframe id="c-pers-split" name="c-pers-split" class="split-c">
    </iframe>

  </div>
<!-- </span> -->

<h1>Common data sets</h1>

<div id="comm-split" class="split-window">
  <span>
    <span id="ana-comm-split" class="split active-split">
      <a id="a-ana-comm-split" class="splitlink"
	 href="analize.php?iframe=true">
	<img class="splitimg" src="../images/stock_task.png" />
	Analyze</a>
    </span>
  </span>
  <span class="admin">
    <span id="add-comm-split" class="split">
      <a id="a-add-comm-split"  class="splitlink"
	 href="add.php?iframe=true">
	<img class="splitimg" src="../images/stock_todo.png" />
	Add</a></span>
    <span id="del-comm-split" class="split">
	<a id="a-del-comm-split"  class="splitlink"
	   href="delete.php?iframe=true">
	<img class="splitimg" src="../images/stock_minus.png" />
	  Delete</a></span>
  </span>

  <iframe id="c-comm-split" name="c-comm-split" class="split-c">
  </iframe>
</div>

<?php
   clus_tail();
?>
