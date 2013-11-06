<?php

require("../include/clusterizator.php");
require("include/menu.php");
requirejs("include/change-passwd.js");

clus_head();
show_menu();

?>

<span class="logged">
<h1> Change password </h1>
<form action="javascript:void(0)" name="passwdform" 
      method="post" onsubmit='passwd(event)'>
  <label>Insert old password</label><br />
  <input id="oldpwd" type="password" maxlength=12 name="oldpwd" value="" />
  <br />
  <label>Insert new password</label><br />
  <input id="newpwd" type="password" maxlength=12 name="newpwd" value="" />
  <br />
  <input type="submit" value="Change password">
</form>
<p id="usererror"></p>
</span>

<?php
   clus_end();
?>
