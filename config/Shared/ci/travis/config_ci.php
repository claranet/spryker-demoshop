<?php

use Pyz\Shared\Newsletter\NewsletterConstants;
use Pyz\Yves\Application\YvesBootstrap;
use Pyz\Zed\Application\Communication\ZedBootstrap;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Collector\CollectorConstants;
use Spryker\Shared\Customer\CustomerConstants;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\Mail\MailConstants;
use Spryker\Shared\Payolution\PayolutionConstants;
use Spryker\Shared\Payone\PayoneConstants;
use Spryker\Shared\ProductManagement\ProductManagementConstants;
use Spryker\Shared\Propel\PropelConstants;
use Spryker\Shared\Search\SearchConstants;
use Spryker\Shared\Session\SessionConstants;
use Spryker\Shared\Setup\SetupConstants;
use Spryker\Shared\Storage\StorageConstants;
use Spryker\Shared\Testify\TestifyConstants;
use Spryker\Shared\Twig\TwigConstants;
use Spryker\Shared\ZedRequest\ZedRequestConstants;

$CURRENT_STORE = Store::getInstance()->getStoreName();

// ---------- General
$config[KernelConstants::SPRYKER_ROOT] = APPLICATION_ROOT_DIR . '/vendor/spryker';

// ---------- Yves host
$config[ApplicationConstants::HOST_YVES] = 'www.de.spryker.test';
$config[ApplicationConstants::PORT_YVES] = '';
$config[ApplicationConstants::PORT_SSL_YVES] = '';
$config[ApplicationConstants::BASE_URL_YVES] = sprintf(
    'http://%s%s',
    $config[ApplicationConstants::HOST_YVES],
    $config[ApplicationConstants::PORT_YVES]
);
$config[ApplicationConstants::BASE_URL_SSL_YVES] = sprintf(
    'https://%s%s',
    $config[ApplicationConstants::HOST_YVES],
    $config[ApplicationConstants::PORT_SSL_YVES]
);
$config[ProductManagementConstants::BASE_URL_YVES] = $config[ApplicationConstants::BASE_URL_YVES];
$config[PayoneConstants::BASE_URL_YVES] = $config[ApplicationConstants::BASE_URL_YVES];
$config[PayolutionConstants::BASE_URL_YVES] = $config[ApplicationConstants::BASE_URL_YVES];
$config[NewsletterConstants::BASE_URL_YVES] = $config[ApplicationConstants::BASE_URL_YVES];
$config[CustomerConstants::BASE_URL_YVES] = $config[ApplicationConstants::BASE_URL_YVES];
$config[ApplicationConstants::YVES_TRUSTED_HOSTS] = [];

// ---------- Zed host
$config[ApplicationConstants::HOST_ZED] = 'zed.de.spryker.test';
$config[ApplicationConstants::PORT_ZED] = ':80';
$config[ApplicationConstants::PORT_SSL_ZED] = ':80';
$config[ApplicationConstants::BASE_URL_ZED] = sprintf(
    'http://%s%s',
    $config[ApplicationConstants::HOST_ZED],
    $config[ApplicationConstants::PORT_ZED]
);
$config[ApplicationConstants::BASE_URL_SSL_ZED] = sprintf(
    'https://%s%s',
    $config[ApplicationConstants::HOST_ZED],
    $config[ApplicationConstants::PORT_SSL_ZED]
);
$config[ZedRequestConstants::HOST_ZED_API] = $config[ApplicationConstants::HOST_ZED];
$config[ZedRequestConstants::BASE_URL_ZED_API] = $config[ApplicationConstants::BASE_URL_ZED];
$config[ZedRequestConstants::BASE_URL_SSL_ZED_API] = $config[ApplicationConstants::BASE_URL_SSL_ZED];

// ---------- Assets / Media
$config[ApplicationConstants::BASE_URL_STATIC_ASSETS] = $config[ApplicationConstants::BASE_URL_YVES];
$config[ApplicationConstants::BASE_URL_STATIC_MEDIA] = $config[ApplicationConstants::BASE_URL_YVES];
$config[ApplicationConstants::BASE_URL_SSL_STATIC_ASSETS] = $config[ApplicationConstants::BASE_URL_SSL_YVES];
$config[ApplicationConstants::BASE_URL_SSL_STATIC_MEDIA] = $config[ApplicationConstants::BASE_URL_SSL_YVES];

// ---------- Testify
$config[TestifyConstants::BOOTSTRAP_CLASS_YVES] = YvesBootstrap::class;
$config[TestifyConstants::BOOTSTRAP_CLASS_ZED] = ZedBootstrap::class;

// ---------- Redis
$config[StorageConstants::STORAGE_REDIS_PROTOCOL] = 'tcp';
$config[StorageConstants::STORAGE_REDIS_HOST] = '127.0.0.1';
$config[StorageConstants::STORAGE_REDIS_PORT] = '6379';
$config[StorageConstants::STORAGE_REDIS_PASSWORD] = '';
$config[StorageConstants::STORAGE_REDIS_DATABASE] = 3;

// ---------- Propel
$config[PropelConstants::ZED_DB_ENGINE] = $config[PropelConstants::ZED_DB_ENGINE_PGSQL];
$config[PropelConstants::ZED_DB_USERNAME] = 'postgres';
$config[PropelConstants::ZED_DB_PASSWORD] = '';
$config[PropelConstants::ZED_DB_DATABASE] = 'DE_test_zed';
$config[PropelConstants::ZED_DB_HOST] = '127.0.0.1';
$config[PropelConstants::ZED_DB_PORT] = 5432;
$config[PropelConstants::USE_SUDO_TO_MANAGE_DATABASE] = false;

// ---------- Elasticsearch
$ELASTICA_INDEX_NAME = 'de_search';
$ELASTICA_DOCUMENT_TYPE = 'page';
$ELASTICA_PORT = '9200';
$config[ApplicationConstants::ELASTICA_PARAMETER__INDEX_NAME] = $ELASTICA_INDEX_NAME;
$config[CollectorConstants::ELASTICA_PARAMETER__INDEX_NAME] = $ELASTICA_INDEX_NAME;
$config[SearchConstants::ELASTICA_PARAMETER__INDEX_NAME] = $ELASTICA_INDEX_NAME;
$config[ApplicationConstants::ELASTICA_PARAMETER__DOCUMENT_TYPE] = $ELASTICA_DOCUMENT_TYPE;
$config[CollectorConstants::ELASTICA_PARAMETER__DOCUMENT_TYPE] = $ELASTICA_DOCUMENT_TYPE;
$config[SearchConstants::ELASTICA_PARAMETER__DOCUMENT_TYPE] = $ELASTICA_DOCUMENT_TYPE;
$config[ApplicationConstants::ELASTICA_PARAMETER__PORT] = $ELASTICA_PORT;
$config[SearchConstants::ELASTICA_PARAMETER__PORT] = $ELASTICA_PORT;
$config[SearchConstants::SEARCH_INDEX_NAME_SUFFIX] = '';

// ---------- Session
$config[SessionConstants::SESSION_IS_TEST] = (bool)getenv("SESSION_IS_TEST");
$config[SessionConstants::YVES_SESSION_COOKIE_NAME] = $config[ApplicationConstants::HOST_YVES];
$config[SessionConstants::YVES_SESSION_COOKIE_DOMAIN] = $config[ApplicationConstants::HOST_YVES];
$config[SessionConstants::YVES_SESSION_REDIS_PROTOCOL] = $config[StorageConstants::STORAGE_REDIS_PROTOCOL];
$config[SessionConstants::YVES_SESSION_REDIS_HOST] = $config[StorageConstants::STORAGE_REDIS_HOST];
$config[SessionConstants::YVES_SESSION_REDIS_PORT] = $config[StorageConstants::STORAGE_REDIS_PORT];
$config[SessionConstants::YVES_SESSION_REDIS_PASSWORD] = $config[StorageConstants::STORAGE_REDIS_PASSWORD];
$config[SessionConstants::YVES_SESSION_REDIS_DATABASE] = 1;
$config[SessionConstants::ZED_SESSION_COOKIE_NAME] = $config[ApplicationConstants::HOST_ZED];
$config[SessionConstants::ZED_SESSION_REDIS_PROTOCOL] = $config[SessionConstants::YVES_SESSION_REDIS_PROTOCOL];
$config[SessionConstants::ZED_SESSION_REDIS_HOST] = $config[SessionConstants::YVES_SESSION_REDIS_HOST];
$config[SessionConstants::ZED_SESSION_REDIS_PORT] = $config[SessionConstants::YVES_SESSION_REDIS_PORT];
$config[SessionConstants::ZED_SESSION_REDIS_PASSWORD] = $config[SessionConstants::YVES_SESSION_REDIS_PASSWORD];
$config[SessionConstants::ZED_SESSION_REDIS_DATABASE] = 2;

// ---------- Twig
$config[TwigConstants::YVES_PATH_CACHE_ENABLED] = true;
$config[TwigConstants::YVES_PATH_CACHE_FILE] = sprintf(
    '%s/data/%s/cache/Yves/twig/.pathCache',
    APPLICATION_ROOT_DIR,
    $CURRENT_STORE
);
$config[TwigConstants::ZED_PATH_CACHE_ENABLED] = true;
$config[TwigConstants::ZED_PATH_CACHE_FILE] = sprintf(
    '%s/data/%s/cache/Zed/twig/.pathCache',
    APPLICATION_ROOT_DIR,
    $CURRENT_STORE
);

// ---------- Jenkins
$config[SetupConstants::JENKINS_BASE_URL] = 'http://localhost:10007/';
$config[SetupConstants::JENKINS_DIRECTORY] = APPLICATION_ROOT_DIR . '/shared/data/common/jenkins';

// ---------- Email
$config[MailConstants::MAILCATCHER_GUI] = 'http://' . $config[ApplicationConstants::HOST_ZED] . ':1080';

// ---------- Payone
$config[PayoneConstants::PAYONE] = [
    PayoneConstants::PAYONE_CREDENTIALS_ENCODING => 'UTF-8',
    PayoneConstants::PAYONE_CREDENTIALS_KEY => getenv('PAYONE_CREDENTIALS_KEY'),
    PayoneConstants::PAYONE_CREDENTIALS_MID => getenv('PAYONE_CREDENTIALS_MID'),
    PayoneConstants::PAYONE_CREDENTIALS_AID => getenv('PAYONE_CREDENTIALS_AID'),
    PayoneConstants::PAYONE_CREDENTIALS_PORTAL_ID => getenv('PAYONE_CREDENTIALS_PORTAL_ID'),
    PayoneConstants::PAYONE_PAYMENT_GATEWAY_URL => 'https://api.pay1.de/post-gateway/',
    PayoneConstants::PAYONE_REDIRECT_SUCCESS_URL => sprintf(
        '%s/checkout/success/',
        $config[ApplicationConstants::BASE_URL_YVES]
    ),
    PayoneConstants::PAYONE_REDIRECT_ERROR_URL => sprintf(
        '/checkout/index/',
        $config[ApplicationConstants::BASE_URL_YVES]
    ),
    PayoneConstants::PAYONE_REDIRECT_BACK_URL => sprintf(
        '/checkout/regular-redirect-payment-cancellation/',
        $config[ApplicationConstants::BASE_URL_YVES]
    ),
    PayoneConstants::PAYONE_MODE => '',
];

// ---------- Payolution
$config[PayolutionConstants::TRANSACTION_GATEWAY_URL] = 'https://test.ctpe.net/frontend/payment.prc';
$config[PayolutionConstants::CALCULATION_GATEWAY_URL] = 'https://test-payment.payolution.com/payolution-payment/rest/request/v2';
$config[PayolutionConstants::TRANSACTION_SECURITY_SENDER] = '8a82941850cd6ba60150cdba275b0201';
$config[PayolutionConstants::TRANSACTION_USER_LOGIN] = '8a82941850cd6ba60150cdba275c0205';
$config[PayolutionConstants::TRANSACTION_USER_PASSWORD] = 'EANPb8wg';
$config[PayolutionConstants::CALCULATION_SENDER] = 'Spryker';
$config[PayolutionConstants::CALCULATION_USER_LOGIN] = 'spryker-installment';
$config[PayolutionConstants::CALCULATION_USER_PASSWORD] = '0mQzn5iqhr3idfZZjvsEPOrlDvT97Tg3M5d';
$config[PayolutionConstants::TRANSACTION_MODE] = 'CONNECTOR_TEST';
$config[PayolutionConstants::CALCULATION_MODE] = 'TEST';
$config[PayolutionConstants::TRANSACTION_CHANNEL_PRE_CHECK] = '8a82941850cd6ba60150cdc25e54028f';
$config[PayolutionConstants::TRANSACTION_CHANNEL_INVOICE] = '8a82941850cd6ba60150cdbf9af40280';
$config[PayolutionConstants::TRANSACTION_CHANNEL_INSTALLMENT] = '8a82941850cd6ba60150cdbf9af40280';
$config[PayolutionConstants::CALCULATION_CHANNEL] = 'spryker-installment';
$config[PayolutionConstants::MIN_ORDER_GRAND_TOTAL_INVOICE] = '500';
$config[PayolutionConstants::MAX_ORDER_GRAND_TOTAL_INVOICE] = '500000';
$config[PayolutionConstants::MIN_ORDER_GRAND_TOTAL_INSTALLMENT] = '500';
$config[PayolutionConstants::MAX_ORDER_GRAND_TOTAL_INSTALLMENT] = '500000';
$config[PayolutionConstants::PAYOLUTION_BCC_EMAIL] = 'invoices@payolution.com';
