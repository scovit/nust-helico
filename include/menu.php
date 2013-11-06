<?php

requirecss("include/menu.css");
requirejs("include/menu.js");

function show_menu() {
  global $betatest;

  if (isset($_GET['iframe']))
    return;

    global $webdir;
    global $session;
    $menu = <<< EOF

<div class=menu-box>
<div class=menu>
EOF;
    /* // Beta testing */
    /*   if(islogged()) { */
	$menu .= <<<EOF
<a class="menulink" href="{$webdir}/">
 Home</a> -
<a class="menulink" href="{$webdir}/explore/">
  Explore</a> -
<a class="menulink" href="{$webdir}/tools.php">
Tools</a> - 
<a class="menulink" href="{$webdir}/help/">
Help</a>
EOF;

	if(isadmin()) {
	  $menu .= <<<EOF
 -
<a class="menulink" href="{$webdir}/admin/">Admin </a>
EOF;
	}
/*	// Beta testing */
/*     } else { */
/* 	$menu .= <<<EOF */
/* NucleoidDB is in beta test */
/* EOF; */
/*       } */
    $menu .= <<<EOF
</div>
<div id="login-panel">
EOF;

if(islogged()) {
	$menu .= <<<EOF
	    <p>
	    Logged as <span id="menuusername">{$session['user']}</span></p><p>
	    <a href="{$webdir}/admin/user.php?action=logout">Logout</a> -
	    <a href="{$webdir}/admin/change-passwd.php">Change password</a>
	    </p>
EOF;

    } else {

	$menu .= <<<EOF
  <form action="javascript:void(0)" name="loginform"
	method="post" onsubmit='login(event)'>
      <label>User: </label>
	<input class="loginField" name="username"
	       type="text" maxlength="80" value="" />
      <label>Pass: </label>
	<input class="loginField" name="password"
	       type="password" maxlength="12" value="" />
      <input class="loginField" 
	     type="submit" name="submit" value="Sign In" />
      <p id="usererror">You are not logged in</p>
  </form> 
EOF;
    }

    $menu .= "</div>";
    $menu .= "</div><br />";
    echo $menu;

}

?>
