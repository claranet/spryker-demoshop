#!/usr/bin/php
<?php 

// check own heartbeat
$heartbeat = 0;
exec('php '.getenv('WORKDIR').'/docker/bin/heartbeat.php', $output_unused, $heartbeat);
if($heartbeat !== 0) {
  echo "heartbeat failed\n";
}

// check if we can connect to zed
$ch = curl_init();
curl_setopt($ch, CURLOPT_TIMEOUT, '1'); // one second timeout
curl_setopt($ch, CURLOPT_USERAGENT, 'k8s-cluster-readiness-check');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // do not print html to stdout

$zedSuccess = true;
$stores = explode(' ', getenv("STORES"));
foreach($stores as $applicationStore) {
  if($applicationStore == 'GLOBAL')
    continue;
  $uri = 'https://'.strtolower($applicationStore).getenv('ZED_API_DOMAIN_SUFFIX').'/auth/login';
  curl_setopt($ch, CURLOPT_URL, $uri);
  curl_exec($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200;
  if($code === false) {
    echo "failed to connect to $uri\n";
    $zedSuccess = false;
  }
}

// wait until we did all tests until we exit
// so the user gets a better overview about failing tests
if($zedSuccess && $heartbeat === 0) {
  echo "ready\n";
  exit(0);
}

echo "not ready\n";
exit(1);
