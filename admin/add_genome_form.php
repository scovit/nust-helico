<?php

require("../include/clusterizator.php");

clus_head();

echo <<<EOF

<form action="add_genome.php" method="post"
enctype="multipart/form-data">
<label for="position">Positions list:</label>
<input type="file" name="position" id="position" />
<br />
<label for="code">Code (max 8 char, optional):</label>
<input type="text" maxlength=8 name="code" id="code" />
<br />
<input type="submit" name="submit" value="Submit" />
</form>
<br />
EOF;

clus_end();

?>
