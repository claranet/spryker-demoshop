<?php

use Spryker\Shared\Application\ApplicationConstants as AC;
use Spryker\Shared\Setup\SetupConstants;
use Spryker\Shared\Storage\StorageConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\Propel\PropelConstants;

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
function getenv_default($env_key, $default=null) {
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
  AC::ELASTICA_PARAMETER__HOST => getenv_default('ES_HOST', 'elasticsearch'),
  AC::ELASTICA_PARAMETER__TRANSPORT => getenv_default('ES_PROTOCOL', 'http'),
  AC::ELASTICA_PARAMETER__PORT => getenv_default('ES_PORT', '9200'),
  AC::ELASTICA_PARAMETER__AUTH_HEADER => '',
  AC::ELASTICA_PARAMETER__INDEX_NAME => null, // Store related confi,
  AC::ELASTICA_PARAMETER__DOCUMENT_TYPE => 'page',
  
  // REDIS databases
  StorageConstants::STORAGE_REDIS_DATABASE => $redis_database_counter++,
  StorageConstants::STORAGE_REDIS_PROTOCOL => 'tcp',
  StorageConstants::STORAGE_REDIS_HOST => getenv_default('REDIS_STORAGE_HOST', 'redis'),
  StorageConstants::STORAGE_REDIS_PORT => getenv_default('REDIS_STORAGE_PORT', '6379'),
  StorageConstants::STORAGE_REDIS_PASSWORD => getenv_default('REDIS_STORAGE_PASSWORD', ''),

  SessionConstants::YVES_SESSION_REDIS_DATABASE => $redis_database_counter++,
  SessionConstants::YVES_SESSION_REDIS_PROTOCOL => 'tcp',
  SessionConstants::YVES_SESSION_REDIS_HOST => getenv_default('REDIS_SESSION_HOST', 'redis'),
  SessionConstants::YVES_SESSION_REDIS_PORT => getenv_default('REDIS_SESSION_PORT', '6379'),
  SessionConstants::YVES_SESSION_REDIS_PASSWORD => getenv_default('REDIS_SESSION_PASSWORD', ''),

  SessionConstants::ZED_SESSION_REDIS_DATABASE => $redis_database_counter++,
  SessionConstants::ZED_SESSION_REDIS_PROTOCOL => 'tcp',
  SessionConstants::ZED_SESSION_REDIS_HOST => getenv_default('REDIS_SESSION_HOST', 'redis'),
  SessionConstants::ZED_SESSION_REDIS_PORT => getenv_default('REDIS_SESSION_PORT', '6379'),
  SessionConstants::ZED_SESSION_REDIS_PASSWORD => getenv_default('REDIS_SESSION_PASSWORD', ''),
  
  
  SessionConstants::YVES_SESSION_SAVE_HANDLER => SessionConstants::SESSION_HANDLER_REDIS,
  SessionConstants::YVES_SESSION_TIME_TO_LIVE => SessionConstants::SESSION_LIFETIME_1_HOUR,
  SessionConstants::YVES_SESSION_FILE_PATH    => session_save_path(),
  SessionConstants::YVES_SESSION_PERSISTENT_CONNECTION => $config[StorageConstants::STORAGE_PERSISTENT_CONNECTION],

  SetupConstants::JENKINS_BASE_URL => getenv_default('JENKINS_BASE_URL', 'http://jenkins:8080/'),
# FIXME [bug01] jenkins console commands of spryker/setup do not relies
# completely of calls to a remote jenkins call
  SetupConstants::JENKINS_DIRECTORY => '/tmp/jenkins/jobs',

  PropelConstants::ZED_DB_ENGINE   => $config[PropelConstants::ZED_DB_ENGINE_PGSQL],
  PropelConstants::ZED_DB_USERNAME => getenv_default('ZED_DB_USERNAME'),
  PropelConstants::ZED_DB_PASSWORD => getenv_default('ZED_DB_PASSWORD'),
  PropelConstants::ZED_DB_DATABASE => getenv_default('ZED_DB_DATABASE', 'spryker'),
  PropelConstants::ZED_DB_HOST     => getenv_default('ZED_DB_HOST', 'database'),
  PropelConstants::ZED_DB_PORT     => getenv_default('ZED_DB_PORT', '5432'),

  AC::ELASTICA_PARAMETER__INDEX_NAME => 'de_search',

# Use commands to remote databases instead of local sudo commands. database
# specific client tools like psql for postgres are required nevertheless.
  PropelConstants::USE_SUDO_TO_MANAGE_DATABASE => false,
];
$config = array_merge($config, $config_local);


/**
 * Hostname(s) for Yves - Shop frontend
 * In production you probably use a CDN for static content
 * But BE AWARE: session domain has to match the sites domain!
 */
$config[AC::HOST_YVES]
    = $config[AC::HOST_STATIC_ASSETS]
    = $config[AC::HOST_STATIC_MEDIA]
    = $config[AC::HOST_SSL_YVES]
    = $config[AC::HOST_SSL_STATIC_ASSETS]
    = $config[AC::HOST_SSL_STATIC_MEDIA]
    = $config[SessionConstants::YVES_SESSION_COOKIE_NAME]
    = $config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN]
    = getenv_default('YVES_HOST');

/**
 * Hostname(s) for Zed - Shop frontend
 * In production you probably use HTTPS for Zed
 */
$config[AC::HOST_ZED_GUI]
    = $config[AC::HOST_ZED_API]
    = $config[AC::HOST_SSL_ZED_GUI]
    = $config[AC::HOST_SSL_ZED_API]
    = getenv_default('ZED_HOST');
