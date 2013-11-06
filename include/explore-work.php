<?php
requirejs("include/explore-work.js");
requirejs("include/evaluate_end_set_prnt.js");
requirejs("include/evaluate_end_set_prnt.css");
requirecss("include/explore-work.css");


function export_exploreuser($expuser) {
  echo "\n";
  echo "<span id=\"exploreuser\" class=\"hidden\">{$expuser}</span>";
}

function get_explore_info() {

  if (isset($_GET["username"]))
    $exploreuser = $_GET["username"];
  else
    $exploreuser = "common";

  export_exploreuser($exploreuser);

}


?>