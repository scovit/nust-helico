<?php
   require("../include/clusterizator.php");
   require("include/menu.php");
   require("include/explore-work.php");
   requirejs("include/explore-add-file.js");
   requirecss("include/explore.css");
   requirecss("include/sliding-iframe.css");
   requirejs("include/synonim.js");
   requirecss("include/synonim.css");
   
   clus_head();
   show_menu();
   get_explore_info();
?>

  <div id="box-file-pers-slid" class="sliding-box">
    Upload a single-column text file to create a new gene data set:
    <form id="form-box-file-pers-slid" action="../analizzatore/add_list.php"		method="post" enctype="multipart/form-data"
	  target="upload-pers-target"
	  onsubmit="set_add_output('form-box-file-pers-slid')">
      <input id="user-form-box-file-pers-slid"
	     type="hidden" name="user" />
      <label for="list">Gene data set:</label>
      <input type="file" name="list" /><br />
      <label for="title">Name of the data set (max 128 char):</label>
      <input type="text" size=40 maxlength=128 name="title"
	     value="No title"/>


<h4>

&nbsp  Try these <a href="../upload/Sample_data_sets.zip"> Sample gene lists</a> 
</h4>

 &nbsp The sample zip archive available from the above link contains three sample gene lists and <br/> &nbsp  a README text file. The sample sets can be uploaded above and used to start the analysis.  
  <br/>


      <br />
      <span class='logged'>
	<label for="dir">Directory (max 128 char):</label>
	<input type="text" size=40 maxlength=128 name="dir" />
	<br />
	<label for="readme">Readme (optional):</label>
	<input type="file" name="readme" /><br />
	<label for="original">Source of the data (optional):</label>
	<input type="file" name="original" /><br />
      </span>
      <br />
      <span class='hidden'>
	<label for="cbs">Select a genome:</label>
	<div id="cb-box-file-pers-slid">
	</div>
      </span>
      <div id="synonim-form-box-file-pers-slid"
	   class="synonimtool">
      </div>
      <input id="submit-form-box-file-pers-slid"
	     type="submit" value="Load data set" />
      <small id="result-form-box-file-pers-slid"></small>
      <iframe id="upload-pers-target"
	      name="upload-pers-target"
	      src="#"></iframe>
    </form>
    
  </div>
