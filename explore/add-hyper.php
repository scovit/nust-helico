<?php
   require("../include/clusterizator.php");
   require("include/menu.php");
   require("include/explore-work.php");
   requirejs("include/explore-add-hyper.js");
   requirecss("include/explore.css");
   requirecss("include/sliding.css");
   requirejs("include/sliding.js");
   requirejs("include/explore-subroutine.js");
   requirecss("include/explore-subroutine.css");
   
   clus_head();
   show_menu();
   get_explore_info();
?>

  <div id="box-inter-pers-slid" class="sliding-box">
    This tool will create a new data set with the following  information:
    <form id="form-box-inter-pers-slid" action="../analizzatore/hyper.php"
	  method="post" enctype="multipart/form-data"
	  target="upload-pers-target"
	  onsubmit="set_add_output('form-box-inter-pers-slid')">
      <input id="action-form-box-inter-pers-slid"
	     type="hidden" name="action" value="create" />
      <input id="user-form-box-inter-pers-slid"
	     type="hidden" name="user" />
      <input id="user1-form-box-inter-pers-slid"
	     type="hidden" name="user1" />
      <input id="list1-form-box-inter-pers-slid"
	     type="hidden" name="list1" />
      <input id="user2-form-box-inter-pers-slid"
	     type="hidden" name="user2" />
      <input id="list2-form-box-inter-pers-slid"
	     type="hidden" name="list2" />
      <label for="cbs">Select the first data set:</label>
      <select id="sl1-form-box-inter-pers-slid" name="first"
	      class="intersel">
      </select><br />
      <label for="cbs">Select the second data set:</label>
      <select id="sl2-form-box-inter-pers-slid" name="second"
	      class="intersel">
      </select><br />
      <label for="title">Name of the data set (max 128 char):</label>
      <input type="text" size=40 maxlength=128 name="title" 
	     value="No title" />
      <br />
      <span class='logged'>
	<label for="dir">Directory (max 128 char):</label>
	<input type="text" size=40 maxlength=128 name="dir" />
	<br />
	<label for="readme">Readme (optional):</label>
	<input type="file" name="readme" /><br />
	<label for="original">Source of the data (optional):</label>
	<input type="file" name="original" /><br />
        <br />
      </span>
      <br />
      Hypergeometric test:
      <div class="hypresult" id="hyp-form-box-inter-pers-slid">
	Select two data sets first
      </div>
      <br /><br />
      <input disabled="disabled" id="submit-form-box-inter-pers-slid"
	     type="submit" value="Create data set" />
      <small id="result-form-box-inter-pers-slid"></small>
      <iframe id="upload-pers-target"
	      name="upload-pers-target"
	      src="#"></iframe>
	  </form>
  </div>
