<?php

$tmpfile="";
function cleanuptmpfile() {
  global $tmpfile;

  unlink($tmpfile);
}


function downfile ($file, $mode="b") {
    if (file_exists($file)) {
      if($mode != "t") {
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file));
	ob_clean();
	flush();
	readfile($file);
	exit;
      } else {
        header('Content-Description: File Transfer');
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
	if(stristr($_SERVER["HTTP_USER_AGENT"], "win")==true) {
	  global $tmpfile;
	  $tmpfile = exec("mktemp");
	  register_shutdown_function ('cleanuptmpfile');
	  copy ( $file , $tmpfile );
	  $file = $tmpfile;
	  exec ( "todos {$file}" );
	}
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
      }
    } else {
        $string = "No file uploaded yet\n";
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . strlen($string));
	ob_clean();
	flush();
	echo $string;
	exit;
    }
}
?>
