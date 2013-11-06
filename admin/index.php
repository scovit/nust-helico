<?php

require("../include/clusterizator.php");
require("include/menu.php");

function show_admin_options() {
	 clus_head();
	 show_menu();

	 echo <<<EOF
<h1>Administration tools</h1>
<a href="">Users</a> (show-update-delete users, login as user)<br />
<a href="tables.php">Genomes and Datasets</a>
EOF;

	 clus_tail();
}


if (isadmin ())
   show_admin_options();

?>