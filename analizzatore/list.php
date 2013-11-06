<?php

require("../include/clusterizator.php");
require("include/menu.php");
require("include/database.php");
require("include/info.php");
require("include/list-work.php");
requirejs("include/synonim.js");
requirecss("include/synonim.css");
requirejs("include/list.js");
requirecss("include/list.css");


clus_head();
show_menu();
get_info_or_ask();

?>
<span class="get-list-on">
  Please select a data set to show information: 
</span>
<select id="get-list-tendina" class="intersel" >
</select>

<span class="get-list-off">

    <h1> Information </h1>
    <span class="list-guest">
      <span class="infotitle">Code:</span>
      <span class="infodata prnt_lcode"></span>
    </span>
    <span class="infotitle">Title:</span>
    <span class="infodata prnt_ltitle"></span>
    <span class="list-noguest">
      <span id="description"></span>
      <span id="references"></span>
    </span>
    <br /><span class="infotitle">Gene set: </span>
    <span class="admin">
      <a class="template-href"  
	 href="../admin/genome.php?action=menu&code=@@prnt_gcode@@">
	<span class="basicinfo prnt_gcode"></span>
      </a>
    </span>
    <span class="notadmin">
      <span class="basicinfo prnt_gcode"></span>
    </span>
    <span class="list-noguest">
      <br /><span class="infotitle">Directory: </span>
      <span class="basicinfo prnt_ldirec"></span>
    </span>
    
    <span class="list-owner">
    <div id="synonim-box"
	 class="synonimtool">
    </div>
    </span>

    <h1> Select an option </h1>
    <a class="template-href"  
       href="../admin/list-queries.php?action=showlist&code=@@prnt_lcode@@&user=@@prnt_luser@@">
      Show data set
    </a>
    <br />
    <span class="logged">
      <a class="template-href" 
	 href="../admin/list-queries.php?action=showreadme&code=@@prnt_lcode@@&user=@@prnt_luser@@">
	Show readme file
      </a>
      <br />
      
      <a class="template-href" 
	 href="../admin/list-queries.php?action=downorig&code=@@prnt_lcode@@&user=@@prnt_luser@@">
	Download original data file
      </a>
      <br />
      
      <span class="list-owner">
	<a class="template-href" 
	   href="list-edit.php?code=@@prnt_lcode@@&user=@@prnt_luser@@">
	  Update data set information</a>
	<br />
      </span>
      
      <span class="list-owner">
	<a class="template-href" 
	   href="../admin/list-queries.php?action=delete&code=@@prnt_lcode@@&user=@@prnt_luser@@">
	  Delete this list</a>
	<br />
      </span>
    </span>

    <h1> Tools </h1>
    <a class="template-href" 
       id="cluster_link" href="../analizzatore/cluster.php?code=@@prnt_lcode@@&user=@@prnt_luser@@">
      Perform the linear aggregation analysis</a><br />


    <a class="template-href" 
       id="cluster_link" href="../analizzatore/sliding.php?code=@@prnt_lcode@@&user=@@prnt_luser@@">
      Produce a multiple sliding window histogram</a><br />


    <a class="template-href"
       id="cluster_link" href="pearson.php?code=@@prnt_lcode@@&user=@@prnt_luser@@">
      Compare histograms using local Pearson correlation coefficient</a>


</span>

    <br /><br />



    <a href="..">
    Go to main page</a>

<?php
   clus_end();
?>
