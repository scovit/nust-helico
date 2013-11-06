<?php

// start a job and take care of updating the database of jobs
// outputs are saved in outfile and errfile
// support for an infile can be added straightforwardly if needed
// should sobstitute cat with sendmail -n
function start_job ($commandline, $outfile, $errfile) {
  global $dbfile;

  // Hackfest script
  $command = <<< COM
export ID=$(
sqlite3 {$dbfile} << EOF
.timeout 60000
BEGIN TRANSACTION;
INSERT INTO jobs (start) VALUES (datetime('now'));
SELECT last_insert_rowid();
END TRANSACTION;
EOF
)
echo \$ID
nohup bash -c '
echo The job id is \$ID
{$commandline}
RETURNVAL=\$?;
echo The return value is \$RETURNVAL
sqlite3 {$dbfile} << EOF
.timeout 60000
UPDATE jobs SET exit_code=\$RETURNVAL, stop=datetime("now") WHERE rec_id=\$ID;
EOF
EMAIL=$(
sqlite3 -nullvalue NULL {$dbfile} << EOF
SELECT email FROM jobs where rec_id=\$ID;
EOF
)
if [ \$EMAIL != NULL ]
    then
/usr/sbin/sendmail -t -i -f vittore.scolari@upmc.fr << EOF
To: \$EMAIL
From: vittore.scolari@upmc.fr
Subject: Job finished
Content-type: text/plain

The job n. \$ID is finished with exit code \$RETURNVAL.
EOF
fi
' > {$outfile} 2> {$errfile} &
COM;

    $id = exec($command);

    if (!is_numeric($id))
       $id = 127;

    return $id;
}

function job_get_mail($job) {
  global $dbh;
  $query=sprintf("SELECT email FROM jobs where rec_id=%u", $job);

  $result = $dbh->query($query);
  $mail = $result->fetchColumn($result);
  if(isset($mail))
    return $mail;
  else
    return FALSE;
  
}

function job_set_mail($job, $mail) {
  global $dbh;
  $query=sprintf("UPDATE jobs SET email=%s WHERE rec_id=%u",
		 $dbh->quote($mail), $job);
  if ($dbh->exec($query) != 1) {
    echo "internal error, couldn't set job mail <br />";
    echo '<br />';
  }
}


?>
