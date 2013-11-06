<?php

require("../include/clusterizator.php");
require("include/database.php");

function getSalt() {
    $c = explode(" ", ". / a A b B c C d D e E f F g G h H i I j J k K l L m M n N o O p P q Q r R s S t T u U v V w W x X y Y z Z 0 1 2 3 4 5 6 7 8 9");
    $ks = array_rand($c, 22);
    $s = "";
    foreach($ks as $k) { $s .= $c[$k]; }
    return "\$2a\$07\$" . $s;
}

function valid_user($user, $pass, &$privilege) {
  global $dbh;
  $query = sprintf("SELECT privilege, pass FROM users
                    WHERE user=%s",
		   $dbh->quote($user));
  $result = $dbh -> query($query);
  if ($result != false) {
    $row = $result->fetch(PDO::FETCH_NUM);
    if(($row != false) &&
       (($row[1] === crypt($pass, $row[1])) ||
	(($row[1][0] != '$') && ($pass === $row[1])))) {
      $privilege = $row[0];
      return TRUE;
    }
  }
  return FALSE;
}

function valid_passwd($pwd) {
  if(strpos ($pwd , "&") ||
     strpos ($pwd , "\\") ||
     strpos ($pwd , "'") ||
     strpos ($pwd , '"') ||
     strpos ($pwd , '$'))
    return false;
  else
    return true;
}

function passwd($oldpwd, $newpwd) {
  global $session;
  global $dbh;
  if(!valid_passwd($oldpwd) ||
     !valid_user($session['user'], $oldpwd, $privilege)) {
    echo "&error 3";
    return;
  }
  if(valid_passwd($newpwd)) {
    $query = sprintf("UPDATE users SET pass=%s WHERE user=%s",
		     $dbh->quote(crypt($newpwd, getSalt())),
		     $dbh->quote($session['user']));
    if($dbh->exec($query) == 1) {
      echo "&end";
      return;
    } else  {
      echo "&error 5";
    }
  }
  else {
    echo "&error 4";
  }
}

function login($user, $pass) {
  global $session;
    if(!valid_passwd($pass) || valid_user($user, $pass, $privilege))
	{
	    $session['user'] = $user;
	    $session['privilege'] = $privilege;
	    echo "&end";
	}
    else
	{
	    echo "&notfound";
	}

}

function getperm() {
    if (!islogged()) {
	echo "&notlogged";
    } else if (isadmin()) {
	echo "&admin";
    } else {
	echo "&logged";
    }
}

if (!isset($_REQUEST["action"]))
    $action="unknown";
else
    $action=$_REQUEST["action"];

switch ($action) {
case "logout":
    destroy_session();
    header('Location: ..');
    break;
case "login":
    if(isset($_POST['username']) && ($_POST['password']))
	{
	    login($_POST['username'], $_POST['password']);
	} else {
	echo "&error 2";
    }
    break;
case "passwd":
    if(!islogged()) {
      echo "&error 3";
      break;
    }

    if(isset($_POST['oldpwd']) && ($_POST['newpwd']))
      {
	passwd($_POST['oldpwd'], $_POST['newpwd']);
      } else {
      echo "&error 2";
      break;
    }

    break;
case "getperm":
    getperm();
    break;
default:
    echo "&error 1";
}
