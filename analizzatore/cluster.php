<?php

require("../include/clusterizator.php");
require("include/menu.php");
require("include/database.php");
require("include/info.php");
require("include/list-work.php");
requirecss("include/slider.css");
requirejs("include/slider.js");
requirejs("include/cluster.js");

clus_head();
show_menu();
get_info_or_ask();

?>

<span class="get-list-on">
  Please select a list: 
</span>
<select id="get-list-tendina" class="intersel" >
</select>

<span class="get-list-off">
  <h1>Linear aggregation analysis of a dataset
    <sup><a href="../help/index.php#x1-80002.2" >?</a></sup>
  </h1>
  <span id="allright">
    <img class="graceplot"
	 id="cluplot"
	 alt="Clusters" />
    <br />
    <a
       id="cluplotget">
  Save as grace (.agr) file</a> (follow <a href="http://plasma-gate.weizmann.ac.il/Grace/">this link</a> for information on this format) 
     or 
    <a
       id="cluplotpdf">
      Save pdf file
    </a>
   <br/> <br/>
   Follow <a href="../help/#x1-80002.2"> this link</a> for help interpreting this plot.
    
    <h1>Draw the clusters found on E. coli chromosome</h1>
    <div>
      <label for="bins">Select bin range: </label>
      <input type="text" name="bins1" size="3"
	     id="circular_bins1" value=32> --> 
      <input type="text" name="bins2" size="3"
	     id="circular_bins2" value=128>
      <input type="button" value="Update it"
	     onclick="javascript:update_circular();"/>
    </div>
    <img id="circular"
	 class="naturalsize"
	 alt="Circular representation"
	 />
    <iframe id="summary" width="525px" height="425px"
	    style="border:none;">
      Summary table
    </iframe>
    <br />
    <a
       id="circsvg">
      Save svg file
    </a> or 
    <a
       id="circpdf">
      Save pdf file
    </a> or 
    <a
       id="circtxt">
      Save txt file
    </a> or
    <a
       id="circbaw">
      Save svg file (black&amp;white)
    </a>
  </span>
  <span id="errore">
  </span>

  <br/><br/>

  <a href="../tools.php" >
    Other tools
  </a> - 
  <a href="../help/index.php#x1-80002.2" >
    Help
  </a> - 
  <a href="../help/example.php#x1-10002" >
    Learn by example
  </a><br /><br />
  link to this page: <br/> 

  <a id=here></a>

</span>

<?php
   clus_end();
?>
