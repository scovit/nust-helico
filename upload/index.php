<?php

require("../include/clusterizator.php");
require("include/menu.php");

clus_head();
show_menu();
?>
<h1>Upload a Data Set</h2> 


<div style="display:table-cell; border:none;">
<h2>

&nbsp  Upload a gene list as a single-column text file 
</h2>
  <br/> &nbsp After you upload the file, you can start the analysis by clicking the links that will appear below. 

<br/> <br/>
 &nbsp All the uploaded files are private and will expire at the end of a 24-hour session. 

  <br/>

<iframe src="../explore/add-file.php?username=guest&iframe=true" id="fastadd"
        style="display:block; border:none; width:720px;" >
</iframe>

 <br/> 

<!--<h2>

&nbsp  Try these <a href="./Sample_data_sets.zip"> Sample gene lists</a> 
</h2>

 The sample zip archive available from the above link contains three sample gene lists and <br/> 
  a README text file. The sample sets can be uploaded above and used to start the analysis.  
  <br/>
 <br/>
-->
 <br/>

 

</div>




<br />

<br/>

<img src="../images/HFSP-100-blue.png" alt="HFSP_logo" id="HFSP-logo" style="width: 50px;"/> Grant RGY-0069/2009-C

<?php
clus_end();
?>

