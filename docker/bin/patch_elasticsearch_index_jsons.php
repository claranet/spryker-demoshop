<?php

/*
This script looks up elasticsearch IndexMap json files from common spryker IndexMap
locations and sets the number of shards/replicas for an index.

Those modifications are done in-place.

Background: normaly those json files are comming from dev envs and therefor are
configured to have only 1 shard, which isn't appropriate for a production env.
To make this configurable via env, this script was introduced.

For further information about ES shards/replicas, have a look at
https://www.elastic.co/guide/en/elasticsearch/reference/current/_basic_concepts.html#getting-started-shards-and-replicas
*/


//  C O N F I G

$WORKDIR = $argv[1] ?? '/data/shop';
$es_json_lookups = [
  $WORKDIR.'/src/Pyz/Shared/Search/IndexMap/*.json',
  $WORKDIR.'/vendor/spryker/search/src/Spryker/Shared/Search/IndexMap/*.json'
];

$es_shards   = getenv('ES_INDEX_NUMBER_OF_SHARDS');
$es_replicas = getenv('ES_INDEX_NUMBER_OF_REPLICAS');

if($es_shards === false) {
  $es_shards = 3;
}

if($es_replicas === false) {
  $es_replicas = 3;
}


//  C O D E


function patch_json_file($json_file) {
  global $es_shards;
  global $es_replicas;
  
  echo "set shards ($es_shards) and replicas ($es_replicas) in $json_file\n";
  $json_as_string = file_get_contents($json_file);
  $json_as_array  = json_decode($json_as_string, true);

  $json_as_array['settings']['index']['number_of_shards']   = $es_shards;
  $json_as_array['settings']['index']['number_of_replicas'] = $es_replicas;

  $json_as_string  = json_encode($json_as_array);
  file_put_contents($json_file, $json_as_string);
}

foreach($es_json_lookups as $pattern) {
  foreach(glob($pattern) as $json_file) {
    patch_json_file($json_file);
  }
}
echo "DONE\n";
