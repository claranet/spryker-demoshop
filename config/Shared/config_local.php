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
 * getenv_with_default => getv_w_dflt
 * Calls getenv(...) but also supports a default value, if the
 * given key does not exist.
 * If no default value is set AND the key could not be found,
 * inform user and abort script execution. This should enforce,
 * that required fields are set via ENV!
**/
function getv_w_dflt($env_key, $default=null) {
  $env_value = getenv($env_key);
  
  // print error if an required ENV var is not set
  if($env_value === false && $default === null) {
    echo "[ERROR] missing ENV var: ".$env_key." Abort here!\n";
    exit(1);
  }
  
  return ($env_value === false) ? $default : $env_value;
}


$config[AC::ELASTICA_PARAMETER__HOST] = getv_w_dflt('ES_HOST', 'elasticsearch');
$config[AC::ELASTICA_PARAMETER__TRANSPORT] = getv_w_dflt('ES_PROTOCOL', 'http');
$config[AC::ELASTICA_PARAMETER__PORT] = getv_w_dflt('ES_PORT', '9200');
$config[AC::ELASTICA_PARAMETER__AUTH_HEADER] = '';
$config[AC::ELASTICA_PARAMETER__INDEX_NAME] = null; // Store related config
$config[AC::ELASTICA_PARAMETER__DOCUMENT_TYPE] = 'page';

// REDIS databases
$redis_database_counter = 0;

$config[StorageConstants::STORAGE_REDIS_DATABASE] = $redis_database_counter++;
$config[StorageConstants::STORAGE_REDIS_PROTOCOL] = 'tcp';
$config[StorageConstants::STORAGE_REDIS_HOST] = getv_w_dflt('REDIS_STORAGE_HOST', 'redis');
$config[StorageConstants::STORAGE_REDIS_PORT] = getv_w_dflt('REDIS_STORAGE_PORT', '6379');
$config[StorageConstants::STORAGE_REDIS_PASSWORD] = getv_w_dflt('REDIS_STORAGE_PASSWORD', '');

$config[SessionConstants::YVES_SESSION_REDIS_DATABASE] = $redis_database_counter++;
$config[SessionConstants::YVES_SESSION_REDIS_PROTOCOL] = 'tcp';
$config[SessionConstants::YVES_SESSION_REDIS_HOST] = getv_w_dflt('REDIS_SESSION_HOST', 'redis');
$config[SessionConstants::YVES_SESSION_REDIS_PORT] = getv_w_dflt('REDIS_SESSION_PORT', '6379');
$config[SessionConstants::YVES_SESSION_REDIS_PASSWORD] = getv_w_dflt('REDIS_SESSION_PASSWORD', '');

$config[SessionConstants::ZED_SESSION_REDIS_DATABASE] = $redis_database_counter++;
$config[SessionConstants::ZED_SESSION_REDIS_PROTOCOL] = 'tcp';
$config[SessionConstants::ZED_SESSION_REDIS_HOST] = getv_w_dflt('REDIS_SESSION_HOST', 'redis');
$config[SessionConstants::ZED_SESSION_REDIS_PORT] = getv_w_dflt('REDIS_SESSION_PORT', '6379');
$config[SessionConstants::ZED_SESSION_REDIS_PASSWORD] = getv_w_dflt('REDIS_SESSION_PASSWORD', '');

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
    = getv_w_dflt('YVES_HOST');

/**
 * Hostname(s) for Zed - Shop frontend
 * In production you probably use HTTPS for Zed
 */
$config[AC::HOST_ZED_GUI]
    = $config[AC::HOST_ZED_API]
    = $config[AC::HOST_SSL_ZED_GUI]
    = $config[AC::HOST_SSL_ZED_API]
    = getv_w_dflt('ZED_HOST');

$config[SessionConstants::YVES_SESSION_SAVE_HANDLER] = SessionConstants::SESSION_HANDLER_REDIS;
$config[SessionConstants::YVES_SESSION_TIME_TO_LIVE] = SessionConstants::SESSION_LIFETIME_1_HOUR;
$config[SessionConstants::YVES_SESSION_FILE_PATH]    = session_save_path();
$config[SessionConstants::YVES_SESSION_PERSISTENT_CONNECTION]
    = $config[StorageConstants::STORAGE_PERSISTENT_CONNECTION];

$config[SetupConstants::JENKINS_BASE_URL] = getv_w_dflt('JENKINS_BASE_URL', 'http://jenkins:8080/');
# FIXME [bug01] jenkins console commands of spryker/setup do not relies
# completely of calls to a remote jenkins call
$config[SetupConstants::JENKINS_DIRECTORY] = '/tmp/jenkins/jobs';

$config[PropelConstants::ZED_DB_ENGINE]   = $config[PropelConstants::ZED_DB_ENGINE_PGSQL];
$config[PropelConstants::ZED_DB_USERNAME] = getv_w_dflt('ZED_DB_USERNAME');
$config[PropelConstants::ZED_DB_PASSWORD] = getv_w_dflt('ZED_DB_PASSWORD');
$config[PropelConstants::ZED_DB_DATABASE] = getv_w_dflt('ZED_DB_DATABASE', 'spryker');
$config[PropelConstants::ZED_DB_HOST]     = getv_w_dflt('ZED_DB_HOST', 'database');
$config[PropelConstants::ZED_DB_PORT]     = getv_w_dflt('ZED_DB_PORT', '5432');

$config[AC::ELASTICA_PARAMETER__INDEX_NAME] = 'de_search';

# Use commands to remote databases instead of local sudo commands. database
# specific client tools like psql for postgres are required nevertheless.
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false;
