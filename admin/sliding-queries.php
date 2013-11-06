<?php

// to be simplified: much of getsliding and getpearson are the same code

require("../include/clusterizator.php");
require("include/database.php");
require("include/downfile.php");
require("include/job.php");
require("include/info.php");

$tmpdir="";

function cleanuptmpdir() {
  global $tmpdir;

  $dirscan = scandir($tmpdir . "/datafile");
  foreach ($dirscan as $object)
    if (!is_dir($tmpdir."/datafile/".$object))
      unlink($tmpdir."/datafile/".$object);
  rmdir($tmpdir . "/datafile");

  $dirscan = scandir($tmpdir);
  foreach ($dirscan as $object)
    if (!is_dir($tmpdir."/".$object))
      unlink($tmpdir."/".$object);
  rmdir($tmpdir);
}

function redo_histogram_condition(&$info, $bins, $genomelength) {
  $tocreate = $info['ldir'] . "/cluster/{$bins}.{$genomelength}.sliding.dat";

  if(!file_exists($tocreate))
    return true;

  if((filemtime($tocreate) < filemtime($info['ldir'] . "/list.txt")) || 
     (filemtime($tocreate) < filemtime($info['gdir'] . "/position.txt")))
    return true;

  return false;

}

function redo_histogram(&$info, $bins, $genomelength) {
  global $tmpdir;

  if (!is_dir("{$info['ldir']}/cluster"))
    mkdir("{$info['ldir']}/cluster");

  $positions = file($info['gdir'] . "/position.txt",
		    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  $pos = array();

  foreach($positions as &$linex) {
    $line = split ( "[ \t]", $linex);
    $pos[$line[0]] = ($line[1] + $line[2]) / 2;
  }

  $genes = file($info['ldir'] . "/list.txt",
	       FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  $list = array();
  $i = 0;
  foreach($genes as &$linex) {
    if (isset($pos[$linex])) {
      $list[$i] = $pos[$linex] . "\n";
      $i++;
    }
  }

  file_put_contents($tmpdir . "/elencopos.dat", $list, LOCK_EX);

  exec("randomizzatore/histosmooth 8192 {$bins} 0 {$genomelength} < {$tmpdir}/elencopos.dat > {$info['ldir']}/cluster/{$bins}.{$genomelength}.sliding.dat");

}

function genomelength($gdir) {
  $positions = file($gdir . "/position.txt",
		    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  $max = 0;

  foreach($positions as &$linex) {
    $line = split ( "[ \t]", $linex);
    if ($line[2] > $max) 
      $max = $line[2] + 1;
    if ($line[1] > $max) 
      $max = $line[1] + 1;
  }

  return $max;
}

if (!isset($_GET["action"]))
    $action="unknown";
else
    $action=$_GET["action"];

switch ($action) {
case "getsliding":
  // Get basic parameter

  if (!isset($_GET["format"]))
    $format="png";
  else
    $format=$_GET["format"];
  
  if (!isset($_GET["bins"]) ||
      !is_numeric($_GET["bins"]) ||
      ($_GET["bins"] < 1) ||
      ($_GET["bins"] > 8192)) {
    exit(0);
  }
  $bins=$_GET["bins"];

  if (isset($_GET["normalize"]) && ($_GET["normalize"] == "true"))
    $normalize = true;
  else
    $normalize = false;

  // Get an array of lists to do
  if (!is_array($_GET["code"]) || !is_array($_GET["user"]) ||
      !is_array($_GET["color"])) {
    echo "&error 2";
    break;
  }
      
  $count = 0;
  foreach ($_GET["code"] as $key => &$value) {
    if (isset($_GET["user"][$key])) {
      $info[$count] = list_load_info_code($value,
				      $_GET["user"][$key]);
      if($info[$count] == NULL) {
	echo "&error 4";
	exit(0);
      }

      $count++;
    }
  }

  // Find the bigger genome and get genomesize
  $glength = array();
  for ($i = 0; $i < $count; $i++) {
    if (!isset($glength[$info[$i]["gid"]]))
      $glength[$info[$i]["gid"]] = genomelength($info[$i]["gdir"]);
  }

  $genomelength = max($glength);

  // Create the directory with all data file to make the graph
  $tmpdir = exec("mktemp -d");
  mkdir($tmpdir . "/datafile");
  register_shutdown_function ('cleanuptmpdir'); 

  foreach ($info as &$value) {
    // Look if the file wasn't already generated
    if(redo_histogram_condition($value, $bins, $genomelength))
      redo_histogram($value, $bins, $genomelength);
  }

  foreach ($info as $key => &$value) {
    if ($key > 9)
      break;

    copy ($value['ldir'] . "/cluster/{$bins}.{$genomelength}.sliding.dat",
	  "{$tmpdir}/datafile/{$key}.dat");
    if ($normalize) {
      exec("randomizzatore/normalize {$tmpdir}/datafile/{$key}.dat");

    }
  }

  // Make the appropriate color table and put it into the parfile
  $colortable['Blue'] = '(0, 0, 255), "Blue"';
  $colortable['Red'] = '(255, 0, 0), "Red"';
  $colortable['Lime'] = '(0, 255, 0), "Lime"';
  $colortable['Purple'] = '(148, 0, 211), "Purple"';
  $colortable['Cyan'] = '(0, 255, 255), "Cyan"';
  $colortable['Fuchsia'] = '(255, 0, 255), "Fuchsia"';
  $colortable['Yellow'] = '(255, 255, 0), "Yellow"';
  $colortable['Brown'] = '(188, 143, 143), "Brown"';
  $colortable['Grey'] = '(220, 220, 220), "Grey"';
  $colortable['Black'] = '(0, 0, 0), "Black"';
  
  $colorstring = "";
  for ($i = 0; $i < $count; $i++) {
    $colorstring .= "map color " . (20 + $i) . " to ";
    $colorstring .= $colortable[$_GET["color"][$i]] . "\n";
  }

  file_put_contents("{$tmpdir}/para.par",
		    str_replace('@@color_table@@', $colorstring,
				file_get_contents("graficatore/parfile/" .
						  "sliding.par")));

  switch ($format) {
  case "agr":
    exec("gracebat -settype xy -param {$tmpdir}/para.par -hdevice PNG -hardcopy -printfile {$tmpdir}/{$bins}.{$genomelength}.sliding.png {$tmpdir}/datafile/*.dat -saveall {$tmpdir}/{$bins}.{$genomelength}.sliding.agr");
    downfile("{$tmpdir}/{$bins}.{$genomelength}.sliding.agr");
    break;
  case "png":
    exec("gracebat -settype xy -param {$tmpdir}/para.par -hdevice PNG -hardcopy -printfile {$tmpdir}/{$bins}.{$genomelength}.sliding.png {$tmpdir}/datafile/*.dat -saveall {$tmpdir}/{$bins}.{$genomelength}.sliding.agr");
    exec("mogrify -crop 792x495+0 {$tmpdir}/{$bins}.{$genomelength}.sliding.png");
    downfile("{$tmpdir}/{$bins}.{$genomelength}.sliding.png");
    break;
  case "pdf":
    exec("gracebat -settype xy -param {$tmpdir}/para.par -hdevice EPS -hardcopy -printfile {$tmpdir}/{$bins}.{$genomelength}.sliding.eps {$tmpdir}/datafile/*.dat -saveall {$tmpdir}/{$bins}.{$genomelength}.sliding.agr");
    exec("epstopdf {$tmpdir}/{$bins}.{$genomelength}.sliding.eps --outfile={$tmpdir}/{$bins}.{$genomelength}.sliding.pdf");
    exec("pdfcrop {$tmpdir}/{$bins}.{$genomelength}.sliding.pdf {$tmpdir}/{$bins}.{$genomelength}.sliding.pdf");
    downfile("{$tmpdir}/{$bins}.{$genomelength}.sliding.pdf");
    break;
  case "zip":
    exec("zip -r -j {$tmpdir}/{$bins}.{$genomelength}.sliding.zip {$tmpdir}/datafile");
    downfile("{$tmpdir}/{$bins}.{$genomelength}.sliding.zip");
    break;
  }
  break;

case "getpearson":
  // Get basic parameter

  if (!isset($_GET["format"]))
    $format="png";
  else
    $format=$_GET["format"];
  
  if (!isset($_GET["bins"]) ||
      !is_numeric($_GET["bins"]) ||
      ($_GET["bins"] < 1) ||
      ($_GET["bins"] > 8192)) {
    exit(0);
  }
  $bins=$_GET["bins"];
  $normalize=true;

  // Get an array of lists to do
  if (!is_array($_GET["code"]) || !is_array($_GET["user"])) {
    echo "&error 2";
    break;
  }
      
  $count = 0;
  foreach ($_GET["code"] as $key => &$value) {
    if (isset($_GET["user"][$key])) {
      $info[$count] = list_load_info_code($value,
				      $_GET["user"][$key]);
      if($info[$count] == NULL) {
	echo "&error 4";
	exit(0);
      }

      $count++;
    }
  }
  if ($count != 2) {
    echo "&error 5";
    exit(0);
  }

  // Find the bigger genome and get genomesize
  $glength = array();
  for ($i = 0; $i < $count; $i++) {
    if (!isset($glength[$info[$i]["gid"]]))
      $glength[$info[$i]["gid"]] = genomelength($info[$i]["gdir"]);
  }

  $genomelength = max($glength);

  // Create the directory with all data file to make the graph
  $tmpdir = exec("mktemp -d");
  mkdir($tmpdir . "/datafile");
  register_shutdown_function ('cleanuptmpdir'); 

  foreach ($info as &$value) {
    // Look if the file wasn't already generated
    if(redo_histogram_condition($value, $bins, $genomelength))
      redo_histogram($value, $bins, $genomelength);
  }

  foreach ($info as $key => &$value) {
    if ($key > 9)
      break;

    copy ($value['ldir'] . "/cluster/{$bins}.{$genomelength}.sliding.dat",
	  "{$tmpdir}/datafile/{$key}.dat");
    if ($normalize) {
      exec("randomizzatore/normalize {$tmpdir}/datafile/{$key}.dat");

    }
  }

  $lista1 = file("{$tmpdir}/datafile/0.dat",
		 FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  $lista2 = file("{$tmpdir}/datafile/1.dat",
                 FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  // Get the mean and the variance                                              
  $x1 = 0;
  $x2 = 0;
  $xx1 = 0;
  $xx2 = 0;
  $nele = 0;
  $list12 = array();

  foreach ($lista1 as $key => &$value) {
    $ele1 = explode(" ", $value);
    $ele2 = explode(" ", $lista2[$key]);
    $tmp12 = array($ele1[1], $ele2[1]);

    $x1 += $tmp12[0];
    $xx1 += $tmp12[0] * $tmp12[0];
    $x2 += $tmp12[1];
    $xx2 += $tmp12[1] * $tmp12[1];
    $nele++;

    $list12[(int)$ele1[0]] = $tmp12;
  }

  $x1 /= $nele;
  $x2 /= $nele;
  $xx1 /= $nele;
  $xx2 /= $nele;
  $xx1 -= ($x1 * $x1);
  $xx2 -= ($x2 * $x2);
  $xx1 = sqrt($xx1);
  $xx2 = sqrt($xx2);

  // calculate the correlation
  $mcorr = 0;
  $correlaz = fopen("{$tmpdir}/{$bins}.{$genomelength}.pearson.txt", "w");

  foreach ($list12 as $key => &$value) {
    $corr = ($value[0] - $x1) * ($value[1] - $x2) / ($xx1 * $xx2);
    fwrite($correlaz, $key . "\t" . $corr . "\n");
    $mcorr += $corr;
  }

  fclose($correlaz);
  $mcorr /= $nele;

  switch ($format) {
  case "agr":
    file_put_contents("{$tmpdir}/para.par",
		      str_replace('@@rho@@', substr($mcorr, 0, 4),
				  file_get_contents("graficatore/parfile/" .
						    "correlaz.par")));
    exec("gracebat -settype xy -param {$tmpdir}/para.par -hdevice PNG -hardcopy -printfile {$tmpdir}/{$bins}.{$genomelength}.pearson.png {$tmpdir}/{$bins}.{$genomelength}.pearson.txt -saveall {$tmpdir}/{$bins}.{$genomelength}.pearson.agr");
    downfile("{$tmpdir}/{$bins}.{$genomelength}.pearson.agr");
    break;
  case "png":
    file_put_contents("{$tmpdir}/para.par",
                      str_replace('@@rho@@', substr($mcorr, 0, 4),
                                  file_get_contents("graficatore/parfile/" .
                                                    "correlaz.par")));
    exec("gracebat -settype xy -param {$tmpdir}/para.par -hdevice PNG -hardcopy -printfile {$tmpdir}/{$bins}.{$genomelength}.pearson.png {$tmpdir}/{$bins}.{$genomelength}.pearson.txt -saveall {$tmpdir}/{$bins}.{$genomelength}.pearson.agr");
    exec("mogrify -crop 792x240+0 {$tmpdir}/{$bins}.{$genomelength}.pearson.png");
    downfile("{$tmpdir}/{$bins}.{$genomelength}.pearson.png");
    break;
  case "pdf":
    file_put_contents("{$tmpdir}/para.par",
                      str_replace('@@rho@@', substr($mcorr, 0, 4),
                                  file_get_contents("graficatore/parfile/" .
                                                    "correlaz.par")));
    exec("gracebat -settype xy -param {$tmpdir}/para.par -hdevice EPS -hardcopy -printfile {$tmpdir}/{$bins}.{$genomelength}.pearson.eps {$tmpdir}/{$bins}.{$genomelength}.pearson.txt -saveall {$tmpdir}/{$bins}.{$genomelength}.pearson.agr");
    exec("epstopdf {$tmpdir}/{$bins}.{$genomelength}.pearson.eps --outfile={$tmpdir}/{$bins}.{$genomelength}.pearson.pdf");
    exec("pdfcrop {$tmpdir}/{$bins}.{$genomelength}.pearson.pdf {$tmpdir}/{$bins}.{$genomelength}.pearson.pdf");
    downfile("{$tmpdir}/{$bins}.{$genomelength}.pearson.pdf");
    break;
  case "pdfbaw":
    file_put_contents("{$tmpdir}/para.par",
                      str_replace('@@rho@@', substr($mcorr, 0, 4),
                                  file_get_contents("graficatore/parfile/" .
                                                    "correlaz.bw.par")));
    exec("gracebat -settype xy -param {$tmpdir}/para.par -hdevice EPS -hardcopy -printfile {$tmpdir}/{$bins}.{$genomelength}.pearson.bw.eps {$tmpdir}/{$bins}.{$genomelength}.pearson.txt -saveall {$tmpdir}/{$bins}.{$genomelength}.pearson.bw.agr");
    exec("epstopdf {$tmpdir}/{$bins}.{$genomelength}.pearson.bw.eps --outfile={$tmpdir}/{$bins}.{$genomelength}.pearson.bw.pdf");
    exec("pdfcrop {$tmpdir}/{$bins}.{$genomelength}.pearson.bw.pdf {$tmpdir}/{$bins}.{$genomelength}.pearson.bw.pdf");
    downfile("{$tmpdir}/{$bins}.{$genomelength}.pearson.bw.pdf");
    break;
  case "txt":
    downfile("{$tmpdir}/{$bins}.{$genomelength}.pearson.txt", "t");
    break;
  }
  break;



default:
  echo "&error 1";
}
