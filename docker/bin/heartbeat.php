#!/usr/bin/php
<?php

$heartbeat = file_get_contents('http://localhost/heartbeat');
$status = json_decode($heartbeat, true);

if(is_array($status) === false || $status['status'] !== 'UP') {
  echo "heartbeat failed\n";
  exit(1);
}

echo "succeeded\n";
exit(0);
