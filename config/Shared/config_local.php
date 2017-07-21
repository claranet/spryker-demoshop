<?php

use Spryker\Shared\Application\ApplicationConstants as AC;
use Spryker\Shared\Setup\SetupConstants;
use Spryker\Shared\Storage\StorageConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;

// Get config values from ENV. This enables the infrastructure guys to let the application
// run in different environments without complicated file templating.
// ENV vars are changeable by their deployment tools and or infrastructure services like
//   * confd
//   * ansible
//   * docker
//   * ...

/**
 * getenv() with default
 * Calls getenv(...) but also supports a default value, if the
 * given key does not exist.
 * If no default value is set AND the key could not be found,
 * inform user and abort script execution. This should enforce,
 * that required fields are set via ENV!
**/
function getenvDefault($env_key, $default=null) {
  $env_value = getenv($env_key);
  
  // print error if an required ENV var is not set
  if($env_value === false && $default === null) {
    echo "[ERROR] missing ENV var: ".$env_key." Abort here!\n";
    exit(1);
  }
  
  return ($env_value === false) ? $default : $env_value;
}


$redis_database_counter = 0;

$config_local = [
  LogConstants::LOG_FILE_PATH => '/data/logs/application.log',
  
  AC::ELASTICA_PARAMETER__HOST          => getenvDefault('ES_HOST', 'elasticsearch'),
  AC::ELASTICA_PARAMETER__TRANSPORT     => getenvDefault('ES_PROTOCOL', 'http'),
  AC::ELASTICA_PARAMETER__PORT          => getenvDefault('ES_PORT', '9200'),
  AC::ELASTICA_PARAMETER__AUTH_HEADER   => '',
  AC::ELASTICA_PARAMETER__INDEX_NAME    => null, // Store related confi,
  AC::ELASTICA_PARAMETER__DOCUMENT_TYPE => 'page',
  
  // REDIS databases
  StorageConstants::STORAGE_REDIS_DATABASE      => $redis_database_counter++,
  StorageConstants::STORAGE_REDIS_PROTOCOL      => getenvDefault('REDIS_STORAGE_PROTOCOL', 'tcp'),
  StorageConstants::STORAGE_REDIS_HOST          => getenvDefault('REDIS_STORAGE_HOST', 'redis'),
  StorageConstants::STORAGE_REDIS_PORT          => getenvDefault('REDIS_STORAGE_PORT', '6379'),
  StorageConstants::STORAGE_REDIS_PASSWORD      => getenvDefault('REDIS_STORAGE_PASSWORD', ''),

  SessionConstants::YVES_SESSION_REDIS_DATABASE => $redis_database_counter++,
  SessionConstants::YVES_SESSION_REDIS_PROTOCOL => getenvDefault('REDIS_SESSION_PROTOCOL', 'tcp'),
  SessionConstants::YVES_SESSION_REDIS_HOST     => getenvDefault('REDIS_SESSION_HOST', 'redis'),
  SessionConstants::YVES_SESSION_REDIS_PORT     => getenvDefault('REDIS_SESSION_PORT', '6379'),
  SessionConstants::YVES_SESSION_REDIS_PASSWORD => getenvDefault('REDIS_SESSION_PASSWORD', ''),

  SessionConstants::ZED_SESSION_REDIS_DATABASE  => $redis_database_counter++,
  SessionConstants::ZED_SESSION_REDIS_PROTOCOL  => getenvDefault('REDIS_SESSION_PROTOCOL', 'tcp'),
  SessionConstants::ZED_SESSION_REDIS_HOST      => getenvDefault('REDIS_SESSION_HOST', 'redis'),
  SessionConstants::ZED_SESSION_REDIS_PORT      => getenvDefault('REDIS_SESSION_PORT', '6379'),
  SessionConstants::ZED_SESSION_REDIS_PASSWORD  => getenvDefault('REDIS_SESSION_PASSWORD', ''),
  
  
  SessionConstants::YVES_SESSION_SAVE_HANDLER   => SessionConstants::SESSION_HANDLER_REDIS,
  SessionConstants::YVES_SESSION_TIME_TO_LIVE   => SessionConstants::SESSION_LIFETIME_1_HOUR,
  SessionConstants::YVES_SESSION_FILE_PATH      => session_save_path(),
  SessionConstants::YVES_SESSION_PERSISTENT_CONNECTION => $config[StorageConstants::STORAGE_PERSISTENT_CONNECTION],

  SetupConstants::JENKINS_BASE_URL => 'http://'.getenvDefault('JENKINS_HOST', 'jenkins').':'.getenvDefault('JENKINS_PORT', '8080').'/',
# FIXME [bug01] jenkins console commands of spryker/setup do not relies
# completely of calls to a remote jenkins call
  SetupConstants::JENKINS_DIRECTORY => '/tmp/jenkins/jobs',

  PropelConstants::ZED_DB_ENGINE   => $config[PropelConstants::ZED_DB_ENGINE_PGSQL],
  PropelConstants::ZED_DB_USERNAME => getenvDefault('ZED_DB_USERNAME'),
  PropelConstants::ZED_DB_PASSWORD => getenvDefault('ZED_DB_PASSWORD'),
  PropelConstants::ZED_DB_DATABASE => getenvDefault('ZED_DB_DATABASE', 'spryker'),
  PropelConstants::ZED_DB_HOST     => getenvDefault('ZED_DB_HOST', 'database'),
  PropelConstants::ZED_DB_PORT     => getenvDefault('ZED_DB_PORT', '5432'),

  AC::ELASTICA_PARAMETER__INDEX_NAME => 'de_search',

# Use commands to remote databases instead of local sudo commands. database
# specific client tools like psql for postgres are required nevertheless.
  PropelConstants::USE_SUDO_TO_MANAGE_DATABASE => false,
];
foreach($config_local as $k => $v)
  $config[$k] = $v;

/**
 * detect the current, valid domain, used for Yves.
 * This is a separate function, as it's a more complex szenario.
 * To support local-dev, we need to detect the used domain
 * dynamicaly.
**/
function getYvesDomain() {
  $domain = getenv('PUBLIC_YVES_DOMAIN');
  if($domain) {
    return $domain;
  }
  
  if(isset($_SERVER['HTTP_HOST'])) {
    return (parse_url($_SERVER['HTTP_HOST'], PHP_URL_PORT) === null)
       ? $_SERVER['HTTP_HOST'] // parse_url fails to return PHP_URL_HOST if there is no port set!
       : parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST); // drop port specifications
  }
  
  return ''; // return nothing, if ENV and SERVER key isn't set
}

/**
 * Hostname(s) for Yves - Shop frontend
 * In production you probably use a CDN for static content
 * But BE AWARE: session domain has to match the sites domain!
 */
// ---------- Yves host
$config[AC::HOST_YVES]
        = $config[SessionConstants::YVES_SESSION_COOKIE_NAME]
        = $config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN]
        = getYvesDomain();
$config[AC::BASE_URL_YVES]
        = $config[AC::BASE_URL_STATIC_ASSETS]
        = $config[AC::BASE_URL_STATIC_MEDIA]
        = $config[AC::BASE_URL_SSL_STATIC_ASSETS]
        = $config[AC::BASE_URL_SSL_STATIC_MEDIA]
        = 'http://' . $config[AC::HOST_YVES];

$config[AC::YVES_SSL_ENABLED] = (getenvDefault('YVES_SSL_ENABLED', false) === 'true' );
$config[AC::YVES_COMPLETE_SSL_ENABLED] = (getenvDefault('YVES_COMPLETE_SSL_ENABLED', false) === 'true');

/**
 * Hostname(s) for Zed - Shop frontend
 * In production you probably use HTTPS for Zed
 */
// ---------- Zed host
$config[AC::HOST_ZED]
        = $config[ZedRequestConstants::HOST_ZED_API]
        = $config[SessionConstants::ZED_SESSION_COOKIE_NAME]
        = getenvDefault('ZED_HOST', 'zed');
$config[AC::BASE_URL_ZED]
        = $config[ZedRequestConstants::BASE_URL_ZED_API]
        = 'http://' . $config[AC::HOST_ZED];

$config[AC::ZED_SSL_ENABLED] = (getenvDefault('ZED_SSL_ENABLED', false) === 'true');
$config[ZedRequestConstants::ZED_API_SSL_ENABLED] = (getenvDefault('ZED_API_SSL_ENABLED', false) === 'true');
