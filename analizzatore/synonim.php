<?php

require("../include/clusterizator.php");
require("include/database.php");
require("include/info.php");

header('Content-Type: text/plain');

function open_syntable($filename) {
  $syntable = array();

  if(!file_exists($filename))
    return $syntable;

  $synfile = file( $filename,
		   FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  foreach ($synfile as &$linex) {
    $line = explode('&', $linex, 2);
    $syntable[$line[0]] = $line[1];
  }

  return $syntable;
}

function search_for_synonim(&$syntable, $gene) {
    foreach ($syntable as $line) {
	if($line[0] === $gene)
	    return $line[1];
    }
}

function return_unfound_and_duplicates($info) {
    gene_names_check($info["ldir"], $info["gdir"], $unfound,
		     $duplicates);

    if(isset($unfound)) {
	echo "&unfounds\n";
	$syntable = open_syntable($info["gdir"] . "/synonim.txt");
	foreach($unfound as $gene) {
	  $syn = (isset($syntable[$gene]) ? $syntable[$gene] : false);
	    if($syn) {
		echo "{$gene}&{$syn}\n";
	    } else
		echo $gene . "\n";
	}
    }

    if(isset($duplicates)) {
	echo "&duplicates\n";
	foreach($duplicates as $gene) {
	    echo $gene . "\n";
	}
    }

    echo "&end\n";
}

function delete_gene($info, $gene) {
    $filename = $info['ldir'] . "/list.txt";

    $genes = file($filename,
		  FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($genes as $k => $i) {
	if ($i === $gene) {
	    unset($genes[$k]);
	    continue;
	}
	$genes[$k] .= "\n";
    }

    file_put_contents($filename, $genes, LOCK_EX);

    $genes = file($filename,
		  FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (in_array($gene, $genes, true)) {
	echo "&error 4";
    } else {
	echo "&end\n";
    }
}

function collapse_gene($info, $gene) {
    $filename = $info['ldir'] . "/list.txt";

    $genes = file($filename,
		  FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $mul = 0;
    foreach ($genes as $k => $i) {
	if ($i === $gene) {
	    if ($mul == 0)
		$mul++;
	    else {
		unset($genes[$k]);
		continue;
	    }
	}
	$genes[$k] .= "\n";
    }

    file_put_contents($filename, $genes, LOCK_EX);

    $genes = file($filename,
		  FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (count(preg_grep ( "/^{$gene}\b/", $genes)) != 1) {
	echo "&error 4";
    } else {
	echo "&end\n";
    }
}

function replace_gene($info, $gene, $syn) {
    $filename = $info['ldir'] . "/list.txt";

    if ($gene === $syn) {
      return_unfound_and_duplicates($info);
      return;
    }

    $genes = file($filename,
		  FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($genes as $k => $i) {
	if ($i === $gene)
	    $genes[$k] = $syn;
	$genes[$k] .= "\n";
    }

    file_put_contents($filename, $genes, LOCK_EX);

    $genes = file($filename,
		  FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (in_array($gene, $genes, true)) {
	echo "&error 4";
    } else {
	return_unfound_and_duplicates($info);
    }

}


# Main
if (isset($_GET["id"])) {
    $info = list_load_info($_GET["id"]);
} else if (isset($_GET["code"]) && isset($_GET["user"])) {
    $info = list_load_info_code($_GET["code"], $_GET["user"]);
} else {
    echo "&error 1";
    exit(0);
}

// synonim lock
$fp = fopen($info['ldir'] . "/synonim.lock", "w");
if (!flock($fp, LOCK_EX)) { // do an exclusive lock
  echo "&error 5";
  exit(0);
}

if (!isset($_GET["action"]))
    $action="unknown";
else
    $action=$_GET["action"];

switch ($action) {
case "isok":
  return_unfound_and_duplicates($info);
  break;
  
case "delete":
  if (!isset($_GET["gene"])) {
    echo "&error 2";
  } else
    delete_gene($info, $_GET["gene"]);
  break;
  
case "collapse":
  if (!isset($_GET["gene"])) {
    echo "&error 2";
  } else
    collapse_gene($info, $_GET["gene"]);
  break;
  
case "replace":
  if (!isset($_GET["gene"])) {
    echo "&error 2";
  } else if (!isset($_GET["syn"])) {
    echo "&error 2";
  } else
    replace_gene($info, $_GET["gene"], $_GET["syn"]);
  break;
  
default:
  echo "&error 3";
}

// synonim unlock
flock($fp, LOCK_UN);
fclose($fp);

?>
