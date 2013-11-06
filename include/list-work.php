<?php

requirejs("include/list-work.js");
requirecss("include/list-work.css");
requirejs("include/evaluate_end_set_prnt.js");
requirecss("include/evaluate_end_set_prnt.css");
requirejs("include/explore-subroutine.js");
requirecss("include/explore-subroutine.css");

function export_list_info_js($info) {
  echo "\n";
  echo "<span id=\"lcode\" class=\"hidden\">{$info['lcode']}</span>";
  echo "<span id=\"luser\" class=\"hidden\">{$info['luser']}</span>";
  echo "<span id=\"ltitle\" class=\"hidden\">{$info['ltitle']}</span>";
  echo "<span id=\"ldirec\" class=\"hidden\">{$info['ldirec']}</span>";
  echo "<span id=\"gcode\" class=\"hidden\">{$info['gcode']}</span>";
}

function get_info_or_ask() {

  if (isset($_GET["id"]))
    $info = list_load_info($_GET["id"]);
  else if (isset($_GET["code"]) && isset($_GET["user"]))
    $info = list_load_info_code($_GET["code"], $_GET['user']);
  else {
    $info['lcode'] = $info['luser'] = $info['ltitle'] = $info['gcode'] =
      $info['ldirec'] = "";
  }

  export_list_info_js($info);
  return $info;

}

?>