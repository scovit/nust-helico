<?php

require("../include/clusterizator.php");
require("include/database.php");
require("include/downfile.php");
require("include/job.php");
require("include/info.php");

function look_if_available($info) {
  global $dbh;
  if(isset($info["ljob"])) {
    $query=sprintf("SELECT exit_code FROM jobs WHERE rec_id=%u",
		   $info['ljob']);
    $result=$dbh -> query($query);
    $ecode = $result -> fetchColumn();
    if(isset($ecode) && ($ecode == 0)) {
      // The results are available
      echo "&available";
      return;
    } else if (isset($ecode) && ($ecode != 0)) {
      // The processing encountered an error
      echo "&procerror&{$ecode}";
      return;
    } else {
      echo "&waiting";
      return;
    }
  }

  if (gene_names_check($info["ldir"], $info["gdir"], $unfound, $duplicates)) {
    echo "&synon";
    return;
  }

  $jid = start_job("graficatore/cluster.sh {$info['ldir']} {$info['gdir']} " .
		   "10000 {$info['lcode']}",
		   $info['ldir'] . "/jobout.txt",
		   $info['ldir'] . "/joberr.txt");

  $query=sprintf("UPDATE lists SET job_id=%u WHERE rec_id=%u",
		 $jid, $info['lid']);
  if ($dbh -> exec($query) != 1) {
    echo "&procerror&12";
    return;
  }
  
  $info = list_load_info($info['lid']);
    
  // waiting
  echo "&waiting";
  return;

}

if (isset($_GET["id"]))
  $info = list_load_info($_GET["id"]);
else if (isset($_GET["code"]) && isset($_GET["user"]))
  $info = list_load_info_code($_GET["code"], $_GET['user']);
else {
  exit(0);
}

if (!isset($_GET["action"]))
    $action="unknown";
else
    $action=$_GET["action"];

switch ($action) {
case "available":
  look_if_available($info);
  break;

case "getresults":
  if (!isset($_GET["format"]))
    $format="png";
  else
    $format=$_GET["format"];
  switch ($format) {
  case "agr":
    downfile($info["ldir"] . "/cluster/result.agr");
  case "png":
    downfile($info["ldir"] . "/cluster/result.png");
  case "pdf":
    downfile($info["ldir"] . "/cluster/result.pdf");
  }

case "getcircular":
  if (!isset($_GET["format"]))
    $format="png";
  else
    $format=$_GET["format"];
  
  if ((!isset($_GET["bins1"]) ||
       !is_numeric($_GET["bins1"]) ||
       ($_GET["bins1"] < 1) ||
       ($_GET["bins1"] > 8192)) || 
      (!isset($_GET["bins2"]) ||
       !is_numeric($_GET["bins2"]) ||
       ($_GET["bins2"] < 1) ||
       ($_GET["bins2"] > 8192)))
    exit(0);
  
  $bins1=$_GET["bins1"];
  $bins2=$_GET["bins2"];

  exec("graficatore/circular.sh {$info['ldir']} {$info['gdir']} {$bins1} {$bins2}");
  
  switch ($format) {
  case "svg":
    downfile($info["ldir"] . "/cluster/{$bins1}.{$bins2}.circular.svg");
  case "svgbaw":
    downfile($info["ldir"] . "/cluster/{$bins1}.{$bins2}.circular.bw.svg");
  case "png":
    downfile($info["ldir"] . "/cluster/{$bins1}.{$bins2}.circular.png");
  case "pdf":
    downfile($info["ldir"] . "/cluster/{$bins1}.{$bins2}.circular.pdf");
  case "txt":
    downfile($info["ldir"] . "/cluster/{$bins1}.{$bins2}.circular.txt", "t");
  case "html":
    readfile($info["ldir"] . "/cluster/{$bins1}.{$bins2}.circular.html");
    exit(0);
  }

default:
  echo "&error 1";
}
