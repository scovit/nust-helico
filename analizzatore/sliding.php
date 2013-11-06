<?php

require("../include/clusterizator.php");
require("include/menu.php");
require("include/database.php");
require("include/info.php");
require("include/list-work.php");
requirejs("include/slider.js");
requirecss("include/slider.css");
requirejs("include/sliding-window.js");
requirecss("include/sliding-window.css");

clus_head();
show_menu();
get_info_or_ask();

?>

<span class="get-list-on">
  Please select a list: 
</span>
<select id="get-list-tendina" class="intersel"></select><select class="colorchooser"></select>
<span id="multiple-selection">
</span>

<span class="get-list-off">
  <h1>Multiple sliding window histogram
    <sup><a href="../help/index.php#x1-80002.3" >?</a></sup>
  </h1>
  <span id="allright">
    <label for="bins">Change number of bins</label>
    <input type="text" name="bins" size="3" id="bins"
	   value=64>
    -
    <span id="normalizebox">
      <label for="norm">Normalize?</label>
      <input type="checkbox" name="norm" id="norm">
    </span>
    -
    <input type="button" value="Do it"
	   onclick="javascript:update_sliding_window();"/>
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
    bins (see the <a href="../help/index.php#x1-80002.3"> help pages </a>)
  </small>

  <br /><br />

  <a href="../tools.php" >
    Other tools
  </a> - 
  <a href="../help/index.php#x1-80002.3" >
    Help
  </a> - 
  <a href="../help/example.php#x1-10003" >
    Learn by example
  </a><br /><br />

</span>

<?php
   clus_end();
?>
