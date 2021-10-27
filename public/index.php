<?php

require_once('DB.php');

$db = new DB('open');

if($db->query("SELECT * FROM `rgi1_users`")){
  $results = $db->fetchAll();
}

$db->close();

print_r($results);

// .$query;