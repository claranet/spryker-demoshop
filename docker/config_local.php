<?php

/**
 * Will be moved to config/Shared/config_local.php by build > deps subsection
 */

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\ProductManagement\ProductManagementConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\Search\SearchConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\Setup\SetupConstants;
use Spryker\Shared\Storage\StorageConstants;
use Spryker\Shared\Twig\TwigConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Yves\Log\Plugin\YvesLoggerConfigPlugin;
use Spryker\Zed\Log\Communication\Plugin\ZedLoggerConfigPlugin;
use Spryker\Shared\RabbitMq\RabbitMqEnv;

use Monolog\Logger;


$applicationStore = strtoupper(Store::getInstance()->getStoreName());

$httpHost       = $_SERVER['SERVER_NAME'] ?? 'localhost';
$httpAddress    = $_SERVER['HTTP_HOST'] ?? $httpHost;
$httpScheme     = $_SERVER['HTTP_SCHEME'] ?? 'http';
$sslEnabled     = ($httpScheme === 'https');
$zedApiDomain   = getenv('ZED_API_HOST');
$trustedProxies = [ '127.0.0.0/24', '10.0.0.0/8', '172.16.0.0/12', '192.168.0.0/16' ];


/**
 *   E L A S T I C S E A R C H
**/
$config[SearchConstants::ELASTICA_PARAMETER__TRANSPORT] = getenv('ELASTICSEARCH_PROTOCOL');
$config[SearchConstants::ELASTICA_PARAMETER__HOST] = getenv('ELASTICSEARCH_HOST');
$config[SearchConstants::ELASTICA_PARAMETER__PORT] = getenv('ELASTICSEARCH_PORT');
$config[SearchConstants::ELASTICA_PARAMETER__INDEX_NAME] = strtolower($applicationStore).'_search';


/*   R E D I S

Configure one database for storage and one for sessions. Repeat this for
each configured store.

Use REDIS_STORE_DB_FACTOR to avoid store counter collisions between different
stores.
*/

$stores_indexed       = explode(' ',getenv('STORES'));
$redisDatabaseCounter = array_search($applicationStore, $stores_indexed) + 1; // +1 to avoid "invalid db-index" error

$config[StorageConstants::STORAGE_PREDIS_CLIENT_CONFIGURATION] = [
  'protocol' => 'tcp',
  'host'     => getenv('STORAGE_REDIS_HOST'),
  'port'     => getenv('STORAGE_REDIS_PORT'),
  'password' => getenv('STORAGE_REDIS_PASSWORD'),
  'database' => $redisDatabaseCounter,
];

$config[SessionConstants::YVES_SESSION_REDIS_DATABASE] = $redisDatabaseCounter;
$config[SessionConstants::YVES_SESSION_REDIS_PROTOCOL] = 'redis';
$config[SessionConstants::YVES_SESSION_REDIS_HOST]     = getenv('YVES_SESSION_REDIS_HOST');
$config[SessionConstants::YVES_SESSION_REDIS_PORT]     = getenv('YVES_SESSION_REDIS_PORT');
$config[SessionConstants::YVES_SESSION_REDIS_PASSWORD] = getenv('YVES_SESSION_REDIS_PASSWORD');
$config[SessionConstants::YVES_SESSION_PERSISTENT_CONNECTION] = true;

$config[SessionConstants::ZED_SESSION_REDIS_DATABASE]  = $redisDatabaseCounter;
$config[SessionConstants::ZED_SESSION_REDIS_PROTOCOL]  = 'redis';
$config[SessionConstants::ZED_SESSION_REDIS_HOST]      = getenv('ZED_SESSION_REDIS_HOST');
$config[SessionConstants::ZED_SESSION_REDIS_PORT]      = getenv('ZED_SESSION_REDIS_PORT');
$config[SessionConstants::ZED_SESSION_REDIS_PASSWORD]  = getenv('ZED_SESSION_REDIS_PASSWORD');
$config[SessionConstants::ZED_SESSION_PERSISTENT_CONNECTION] = true;
unset($stores_indexed, $redisDatabaseCounter);

/**
 *   J E N K I N S
 */
$config[SetupConstants::JENKINS_BASE_URL]  = getenv('JENKINS_URL');
$config[SetupConstants::JENKINS_DIRECTORY] = '/tmp/jenkins/jobs';

/**
 *   R A B B I T M Q
 */
// $config[RabbitMqEnv::RABBITMQ_HOST] = getenv('RABBITMQ_HOST');
// $config[RabbitMqEnv::RABBITMQ_PORT] = getenv('RABBITMQ_PORT');
// $config[RabbitMqEnv::RABBITMQ_USERNAME] = getenv('RABBITMQ_USERNAME');
// $config[RabbitMqEnv::RABBITMQ_PASSWORD] = getenv('RABBITMQ_PASSWORD');
// $config[RabbitMqEnv::RABBITMQ_VIRTUAL_HOST] = getenv('RABBITMQ_VIRTUAL_HOST');

$config[RabbitMqEnv::RABBITMQ_CONNECTIONS] = [
    $applicationStore => [
        RabbitMqEnv::RABBITMQ_CONNECTION_NAME => $applicationStore.'-connection',
        RabbitMqEnv::RABBITMQ_HOST => getenv('RABBITMQ_HOST'),
        RabbitMqEnv::RABBITMQ_PORT => getenv('RABBITMQ_PORT'),
        RabbitMqEnv::RABBITMQ_PASSWORD => getenv('RABBITMQ_PASSWORD'),
        RabbitMqEnv::RABBITMQ_USERNAME => getenv('RABBITMQ_USERNAME'),
        RabbitMqEnv::RABBITMQ_VIRTUAL_HOST => getenv('RABBITMQ_VIRTUAL_HOST'),
        RabbitMqEnv::RABBITMQ_STORE_NAMES => [$applicationStore],
        RabbitMqEnv::RABBITMQ_DEFAULT_CONNECTION => true
    ],
];

/**
 *   P O S T G R E S
 */
$database2store = [
  'DE' => getenv('ZED_DATABASE_DATABASE').'_de',
  'AT' => getenv('ZED_DATABASE_DATABASE').'_de',
  'US' => getenv('ZED_DATABASE_DATABASE').'_us',
];
$config[PropelConstants::ZED_DB_ENGINE]   = $config[PropelConstants::ZED_DB_ENGINE_PGSQL];
$config[PropelConstants::ZED_DB_USERNAME] = getenv('ZED_DATABASE_USERNAME');
$config[PropelConstants::ZED_DB_PASSWORD] = getenv('ZED_DATABASE_PASSWORD');
$config[PropelConstants::ZED_DB_DATABASE] = $database2store[$applicationStore];
$config[PropelConstants::ZED_DB_HOST]     = getenv('ZED_DATABASE_HOST');
$config[PropelConstants::ZED_DB_PORT]     = getenv('ZED_DATABASE_PORT');
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false; // this is required to support a remote postgres installation (propel task createdb)
unset($database2store);


$config[ApplicationConstants::HOST_YVES]           = $httpAddress;
$config[ProductManagementConstants::BASE_URL_YVES] = $httpScheme . '://' . $httpAddress;
$config[CustomerConstants::BASE_URL_YVES]          = $httpScheme . '://' . $httpAddress;

$config[SessionConstants::YVES_SESSION_COOKIE_NAME]   = $httpHost;
$config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN] = $httpHost;
$config[SessionConstants::YVES_SESSION_COOKIE_SECURE] = $sslEnabled;

$config[ApplicationConstants::BASE_URL_STATIC_ASSETS]
    = $config[ApplicationConstants::BASE_URL_STATIC_MEDIA]
    = $config[ApplicationConstants::BASE_URL_SSL_YVES]
    = $config[ApplicationConstants::BASE_URL_SSL_STATIC_ASSETS]
    = $config[ApplicationConstants::BASE_URL_SSL_STATIC_MEDIA]
    = $httpHost;

// see https://academy.spryker.com/enablement/howtos/ht_force_https.html
$config[ApplicationConstants::YVES_SSL_ENABLED]     = $sslEnabled;
$config[ApplicationConstants::YVES_TRUSTED_PROXIES] = $trustedProxies;


$config[ApplicationConstants::HOST_ZED]            = $httpAddress;
$config[ApplicationConstants::BASE_URL_ZED]        = $httpScheme . '://' . $httpAddress;
$config[ApplicationConstants::BASE_URL_SSL_ZED]    = $httpScheme . '://' . $httpAddress;
$config[ZedRequestConstants::BASE_URL_ZED_API]     = $zedApiDomain;
$config[ZedRequestConstants::BASE_URL_SSL_ZED_API] = $zedApiDomain;
$config[ApplicationConstants::ZED_TRUSTED_PROXIES] = $trustedProxies;


/**
 *   T W I G
*/
$cacheDirBase = getenv('WORKDIR') . '/cache/' . Store::getInstance()->getStoreName();
$twigCachePathYves =  $cacheDirBase . '/Yves/twig';
$twigCachePathZed  =  $cacheDirBase . '/Zed/twig';
$config[TwigConstants::YVES_TWIG_OPTIONS]['cache'] = $twigCachePathYves;
$config[TwigConstants::ZED_TWIG_OPTIONS]['cache']  = $twigCachePathZed;
$config[TwigConstants::YVES_PATH_CACHE_FILE]       = $twigCachePathYves . '/.pathCache';
$config[TwigConstants::ZED_PATH_CACHE_FILE]        = $twigCachePathZed  . '/.pathCache';


/**
 * A S S E T S
 */
// ... to be defined ..


/**
 *   L O G G I N G
 */
$config[LogConstants::LOGGER_CONFIG_ZED]                = YvesLoggerConfigPlugin::class;
$config[LogConstants::LOGGER_CONFIG_YVES]               = ZedLoggerConfigPlugin::class;
$config[LogConstants::LOG_LEVEL]                        = Logger::NOTICE;
$config[LogConstants::LOG_FILE_PATH]                    = 'php://stdout';
$config[LogConstants::LOG_FILE_PATH_YVES]               = 'php://stdout';
$config[LogConstants::LOG_FILE_PATH_ZED]                = 'php://stdout';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH]          = 'php://stderr';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_YVES]     = 'php://stderr';
$config[LogConstants::EXCEPTION_LOG_FILE_PATH_ZED]      = 'php://stderr';
$config[EventConstants::LOG_FILE_PATH]                  = 'php://stdout';


/**
 *   D E B U G G I N G
 */
$config[ApplicationConstants::ENABLE_WEB_PROFILER]      = false;
$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG] = false;


/**
 *   M A I L I N G
 *
 * Translate "AUTH_MODE" to "AUTH_METHOD" as this is how SMTP and MTAs are calling it (fixes naming)
**/

// $config[MailConstants::SMTP_ENCRYPTION] = getenv('SMTP_ENCRYPTION');
// $config[MailConstants::SMTP_AUTH_MODE]  = getenv('SMTP_AUTH_METHOD');
// $config[MailConstants::SMTP_HOST]       = getenv('SMTP_HOST');
// $config[MailConstants::SMTP_USERNAME]   = getenv('SMTP_USERNAME');
// $config[MailConstants::SMTP_PASSWORD]   = getenv('SMTP_PASSWORD');
// $config[MailConstants::SMTP_PORT]       = getenv('SMTP_PORT');
// $config[MailConstants::SMTP_TIMEOUT]    = (int)getenv('SMTP_TIMEOUT');
