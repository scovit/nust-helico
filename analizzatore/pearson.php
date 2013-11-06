<?php

require("../include/clusterizator.php");
require("include/menu.php");
require("include/database.php");
require("include/info.php");
require("include/list-work.php");
requirejs("include/slider.js");
requirecss("include/slider.css");
requirejs("include/pearson.js");
requirecss("include/pearson.css");

clus_head();
show_menu();
get_info_or_ask();

?>

<span class="get-list-second-on">
    Please select two data sets:
<br />
</span>
<select id="get-list-tendina" class="intersel" >
</select>
<br />
<select id="get-list-second" class="intersel" >
</select>

<span class="get-list-second-off">
<h1> Local Pearson correlation coefficient tool
  <sup><a href="../help/index.php#x1-80002.4">?</a></sup>
</h1>

  <span id="allright">
    <label for="bins">Change the number of bins</label>
    <input type="text" name="bins" size="3" id="bins"
	   value=64>
    -
    <input type="button" value="Do it"
           onclick="javascript:update_pearson_graph();"/>
    <br /><br />
    <img id="sliding"
         class="naturalsize center"
         src="../images/waiting-logo.gif"
         alt="Sliding window" />
    <br />
    <p id="caption" class="loading_message center">
      Loading results...
    </p>
  </span>
  <span id="errore">
  </span>
  

  <br />
  <small>
    Notice: this kind of plot might lose meaning for elevated numbers of
    bins (see the <a href="../help/index.php#x1-80002.4"> help pages </a>)
  </small>

  <br /><br />

  <a href="../tools.php" >
    Other tools
  </a> - 
  <a href="../help/index.php#x1-80002.4" >
    Help
  </a> - 
  <a href="../help/example.php#x1-10004" >
    Learn by example
  </a><br /><br />

</span>

<?php
   clus_end();
?>
