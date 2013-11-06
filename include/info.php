<?php

function can_modify_list($user) {
  global $session;
  if (isadmin())
    return TRUE;

  if ($session["user"] === $user)
    return TRUE;
  
  // We should instead look at the sessionid in guest case
  if (!islogged())
    return FALSE;

  return FALSE;

}

function can_get_listinfo($user, $sessid) {
  global $session;
  if (isadmin())
    return TRUE;

  if ($user === "guest") {
    if ($sessid === $session['sid'])
      return TRUE;
    else
      return FALSE;
  }

  if($user === "common")
    return TRUE;

  if(!islogged())
    return FALSE;
  if($session["user"] === $user)
    return TRUE;
  
  return FALSE;
}

function can_get_listrule($user) {
  global $session;
  if (isadmin())
    return TRUE;

  if(($user === "guest"))
    return TRUE;

  if($user === "common")
    return TRUE;

  if(!islogged())
    return FALSE;
  if($session["user"] === $user)
    return TRUE;
  
  return FALSE;
}

function can_get_list($user) {
    if (isadmin())
	return TRUE;

    foreach ($user as $u) {
      if(can_get_listrule($u))
	continue;
      else
	return FALSE;
    }

    return TRUE;
}

function list_load_info($id) {
  global $dbh;
  $query=sprintf("SELECT lists.rec_id, lists.code, lists.directory, lists.job_id, lists.user_id, lists.title, lists.dir, lists.sid, users.user, genomes.rec_id, genomes.code, genomes.directory, genomes.job_id, genomes.title FROM lists INNER JOIN genomes ON lists.genome = genomes.rec_id INNER JOIN users ON lists.user_id = users.rec_id WHERE lists.rec_id=%u", $id);
    $result = $dbh -> query($query);
    $linfo = $result -> fetch(PDO::FETCH_NUM);
    $returarray = array("lid" => $linfo[0],
			"lcode" => $linfo[1],
			"luid" => $linfo[4],
			"luser" => $linfo[8],
			"ltitle" => $linfo[5],
			"ldirec" => $linfo[6],
			"lsid" => $linfo[7],
			"gid" => $linfo[9],
			"gcode" => $linfo[10],
			"ldir" => $linfo[2],
			"gdir" => $linfo[11],
			"gtitle" => $linfo[13],
			"ljob" => $linfo[3],
			"gjob" => $linfo[12]);

    if (can_get_listinfo($returarray["luser"], $returarray["lsid"]))
	return $returarray;
    else
	return FALSE;
}

function list_load_info_code($code, $user) {
  global $dbh;
  $query=sprintf("SELECT lists.rec_id FROM lists
                  INNER JOIN users ON lists.user_id = users.rec_id 
                  WHERE lists.code=%s AND users.user=%s",
		 $dbh->quote($code),
		 $dbh->quote($user));
  $result=$dbh->query($query);
  $linfo = $result -> fetchColumn();
  return list_load_info($linfo);
}


function genome_load_info($id) {
  global $dbh;
  $query=sprintf("SELECT rec_id, code, title, directory, job_id
                  FROM genomes WHERE rec_id=%u", $id);
  $result=$dbh->query($query);
  $linfo = $result->fetch(PDO::FETCH_NUM);
  return array("gid" => $linfo[0],
	       "gcode" => $linfo[1],
	       "gtitle" => $linfo[2],
	       "gdir" => $linfo[3],
	       "gjob" => $linfo[4]);
}

function genome_load_info_code($code) {
  global $dbh;
  $query=sprintf("SELECT rec_id FROM genomes WHERE code=%s",
		 $dbf->quote($code));
  $result=$dbh->query($query);
  $linfo = $result -> fetchColumn();
  return genome_load_info($linfo);
}

function gene_names_check($listdir, $genomedir, &$unfound, &$duplicates) {
    $genesfile = file($listdir . "/list.txt",
		  FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $positionfile = file($genomedir . "/position.txt",
		      FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach($positionfile as $pos) {
      $posa = split("[ \t]", $pos);
      $flipped_positions[$posa[0]] = true;
    }

    $genes = array_count_values($genesfile);

    foreach($genes as $gene => $conta)
      {
	if (!isset($flipped_positions[$gene])) {
	  $unfound[] = $gene;
    	}
    	if ($conta != 1) {
	  $duplicates[] = $gene;
    	}
      }

    if (isset($unfound))
	$unfound = array_unique($unfound);
    if (isset($duplicates))
	$duplicates = array_unique($duplicates);

    if(isset($unfound) || isset($duplicates))
	return TRUE;
    else
	return FALSE;
}



?>
