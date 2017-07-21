<?php

/**
 * This is the global runtime configuration for Yves and Generated_Yves_Zed in a development environment.
 */

use Spryker\Shared\Acl\AclConstants;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\ErrorHandler\ErrorHandlerConstants;
use Spryker\Shared\EventJournal\EventJournalConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\Search\SearchConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\Setup\SetupConstants;
use Spryker\Shared\Storage\StorageConstants;
use Spryker\Shared\ZedNavigation\ZedNavigationConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;

// ---------- General
$config[KernelConstants::SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker';
$config[ApplicationConstants::ENABLE_APPLICATION_DEBUG] = false;
$config[ZedRequestConstants::SET_REPEAT_DATA] = false;
$config[ApplicationConstants::ENABLE_WEB_PROFILER] = false;
$config[ApplicationConstants::SHOW_SYMFONY_TOOLBAR] = false;
$config[KernelConstants::STORE_PREFIX] = 'DEV';

// ---------- Propel
$config[PropelConstants::PROPEL_DEBUG] = false;
$config[PropelConstants::PROPEL_SHOW_EXTENDED_EXCEPTION] = false;
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false;
$ENV_DB_CONNECTION_DATA = parse_url(getenv(getenv('DATABASE_URL_NAME') ?: 'DATABASE_URL'));
$config[PropelConstants::ZED_DB_ENGINE] = $config[PropelConstants::ZED_DB_ENGINE_PGSQL];
$config[PropelConstants::ZED_DB_USERNAME] = $ENV_DB_CONNECTION_DATA['user'];
$config[PropelConstants::ZED_DB_PASSWORD] = $ENV_DB_CONNECTION_DATA['pass'];
$config[PropelConstants::ZED_DB_DATABASE] = ltrim($ENV_DB_CONNECTION_DATA['path'], '/');
$config[PropelConstants::ZED_DB_HOST] = $ENV_DB_CONNECTION_DATA['host'];
$config[PropelConstants::ZED_DB_PORT] = isset($ENV_DB_CONNECTION_DATA['port']) ? $ENV_DB_CONNECTION_DATA['port'] : 5432;

// ---------- Redis
$ENV_REDIS_CONNECTION_DATA = parse_url(getenv(getenv('REDIS_URL_NAME') ?: 'REDIS_URL'));
$config[StorageConstants::STORAGE_REDIS_PROTOCOL] = $ENV_REDIS_CONNECTION_DATA['scheme'];
$config[StorageConstants::STORAGE_REDIS_HOST] = $ENV_REDIS_CONNECTION_DATA['host'];
$config[StorageConstants::STORAGE_REDIS_PORT] = $ENV_REDIS_CONNECTION_DATA['port'];
$config[StorageConstants::STORAGE_REDIS_PASSWORD] = $ENV_REDIS_CONNECTION_DATA['pass'];

// ---------- RabbitMQ
$config[ApplicationConstants::ZED_RABBITMQ_HOST] = 'localhost';
$config[ApplicationConstants::ZED_RABBITMQ_PORT] = '5672';

// ---------- Session
$config[SessionConstants::YVES_SESSION_COOKIE_SECURE] = false;
$config[SessionConstants::YVES_SESSION_SAVE_HANDLER] = SessionConstants::SESSION_HANDLER_REDIS_LOCKING;
$config[SessionConstants::YVES_SESSION_REDIS_PROTOCOL] = $config[StorageConstants::STORAGE_REDIS_PROTOCOL];
$config[SessionConstants::YVES_SESSION_REDIS_HOST] = $config[StorageConstants::STORAGE_REDIS_HOST];
$config[SessionConstants::YVES_SESSION_REDIS_PORT] = $config[StorageConstants::STORAGE_REDIS_PORT];
$config[SessionConstants::YVES_SESSION_REDIS_PASSWORD] = $config[StorageConstants::STORAGE_REDIS_PASSWORD];
$config[SessionConstants::ZED_SESSION_COOKIE_SECURE] = false;
$config[SessionConstants::ZED_SESSION_SAVE_HANDLER] = SessionConstants::SESSION_HANDLER_REDIS;
$config[SessionConstants::ZED_SESSION_REDIS_PROTOCOL] = $config[SessionConstants::YVES_SESSION_REDIS_PROTOCOL];
$config[SessionConstants::ZED_SESSION_REDIS_HOST] = $config[SessionConstants::YVES_SESSION_REDIS_HOST];
$config[SessionConstants::ZED_SESSION_REDIS_PORT] = $config[SessionConstants::YVES_SESSION_REDIS_PORT];
$config[SessionConstants::ZED_SESSION_REDIS_PASSWORD] = $config[SessionConstants::YVES_SESSION_REDIS_PASSWORD];

// ---------- Elasticsearch
$ENV_ELASTICA_CONNECTION_DATA = parse_url(getenv(getenv('ELASTIC_SEARCH_URL_NAME') ?: 'ELASTIC_SEARCH_URL'));
$ELASTICA_BASIC_AUTH = base64_encode($ENV_ELASTICA_CONNECTION_DATA['user'] . ':' . $ENV_ELASTICA_CONNECTION_DATA['pass']);
$ELASTICA_AUTH_HEADER = str_pad(
    $ELASTICA_BASIC_AUTH,
    strlen($ELASTICA_BASIC_AUTH) + strlen($ELASTICA_BASIC_AUTH) % 4,
    '=',
    STR_PAD_RIGHT
);
$ELASTICA_PORT = ($ENV_ELASTICA_CONNECTION_DATA['scheme'] == 'https' ? 443 : 80);
$config[ApplicationConstants::ELASTICA_PARAMETER__AUTH_HEADER] = $ELASTICA_AUTH_HEADER;
$config[SearchConstants::ELASTICA_PARAMETER__AUTH_HEADER] = $ELASTICA_AUTH_HEADER;
$config[ApplicationConstants::ELASTICA_PARAMETER__HOST] = $ENV_ELASTICA_CONNECTION_DATA['host'];
$config[SearchConstants::ELASTICA_PARAMETER__HOST] = $ENV_ELASTICA_CONNECTION_DATA['host'];
$config[ApplicationConstants::ELASTICA_PARAMETER__TRANSPORT] = $ENV_ELASTICA_CONNECTION_DATA['scheme'];
$config[SearchConstants::ELASTICA_PARAMETER__TRANSPORT] = $ENV_ELASTICA_CONNECTION_DATA['scheme'];
$config[ApplicationConstants::ELASTICA_PARAMETER__PORT] = $ELASTICA_PORT;
$config[SearchConstants::ELASTICA_PARAMETER__PORT] = $ELASTICA_PORT;

// ---------- Jenkins
$config[SetupConstants::JENKINS_DIRECTORY] = '/data/shop/development/shared/data/common/jenkins';

// ---------- Zed request
$config[ZedRequestConstants::TRANSFER_DEBUG_SESSION_FORWARD_ENABLED] = false;

// ---------- Payone
$config[PayoneConstants::PAYONE] = [
    PayoneConstants::PAYONE_CREDENTIALS_ENCODING => 'UTF-8',
    PayoneConstants::PAYONE_CREDENTIALS_KEY => '',
    PayoneConstants::PAYONE_CREDENTIALS_MID => '',
    PayoneConstants::PAYONE_CREDENTIALS_AID => '',
    PayoneConstants::PAYONE_CREDENTIALS_PORTAL_ID => '',
    PayoneConstants::PAYONE_PAYMENT_GATEWAY_URL => 'https://api.pay1.de/post-gateway/',
    PayoneConstants::PAYONE_MODE => '',
];

// ---------- Navigation
$config[ZedNavigationConstants::ZED_NAVIGATION_CACHE_ENABLED] = true;

// ---------- ACL
$config[AclConstants::ACL_USER_RULE_WHITELIST][] = [
    'bundle' => 'wdt',
    'controller' => '*',
    'action' => '*',
    'type' => 'allow',
];

// ---------- Error handling
$config[ErrorHandlerConstants::DISPLAY_ERRORS] = true;

// ---------- Logging
$config[LogConstants::LOG_LEVEL] = 0;

// ---------- Event journal
$config[EventJournalConstants::WRITERS]['YVES'] = [];
$config[EventJournalConstants::WRITERS]['ZED'] = [];
