<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\IntrospectionProcessor;
use Phalcon\Db\Adapter\Pdo\Mysql;

# Logger
$di->setShared('logger', function () use ($config, $di) {
    $format = new Monolog\Formatter\LineFormatter("[%datetime%] %level_name%: %message% %context%\n");

    $stdout = new StreamHandler('php://stdout', getenv('DEBUG') ? Logger::DEBUG : Logger::INFO);
    $stdout->setFormatter($format);

    $stream = new StreamHandler(ini_get('error_log'), getenv('DEBUG') ? Logger::DEBUG : Logger::INFO); // use Logger::WARNING for production
    $stream->setFormatter($format);

    $log = new Logger(__FUNCTION__);
    $log->pushProcessor(new IntrospectionProcessor());
    $log->pushHandler($stdout);
    $log->pushHandler($stream);

    return $log;
});

$di->setShared('crypt', function () use ($config) {
    $crypt = new \Phalcon\Crypt();
    $crypt->setMode(MCRYPT_MODE_CFB);

    return $crypt;
});

# Session
$di->setShared('session', function () use ($config) {
    $params = [];

    if (!empty($config->project->sess_prefix)) {
        $params['uniqueId'] = $config->project->sess_prefix;
    }

    $session = new \Phalcon\Session\Adapter\Files($params);
    $session->start();

    return $session;
});

# Cookies
$di->setShared('cookies', function () {
    $cookies = new \Phalcon\Http\Response\Cookies();
    $cookies->useEncryption(false);

    return $cookies;
});

# Config
$di->setShared('config', $config);

# Mailer (requires composer component)
$di->setShared('mailer', function () use ($config) {
    $mailer = new \App\Lib\Mailer([
        'templates' => APP_PATH . 'common/emails/',
        'host'      => $config->smtp->host,
        'port'      => $config->smtp->port,
        'username'  => $config->smtp->username,
        'password'  => $config->smtp->password,
        'security'  => $config->smtp->security
    ]);

    if (!empty($config->project->admin_email) && !empty($config->project->admin_name)) {
        $mailer->setFrom($config->project->admin_email, $config->project->admin_name);
    }

    return $mailer;
});

# Memcached
$di->setShared('memcached', function () use ($config) {
    $m = new \Memcached();
    $m->addServer('memcached', 11211);
    return $m;
});

$di->setShared('flash', function () {
    return new \Phalcon\Flash\Session([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning',
    ]);
});

$di->setShared("db", function () use ($config) {
   return new Mysql([
       "host"     => 'mysql',
       "username" => getenv("DB_USER"),
       "password" => getenv("DB_PASSWORD"),
       "dbname"   => getenv("DB_NAME"),
       'charset'           => 'utf8',
       'collation'         => 'utf8_unicode_ci',
       'options' => [
           PDO::ATTR_EMULATE_PREPARES => false,
           PDO::ATTR_STRINGIFY_FETCHES => false,
       ]
   ]);
});

$di->setShared('querybuilder', function () use ($config) {
    $conn = new \Pixie\Connection('mysql', [
        'host'              => 'mysql',
        'database'          => getenv('DB_NAME'),
        'username'          => getenv('DB_USER'),
        'password'          => getenv('DB_PASSWORD'),
        'charset'           => 'utf8',
        'collation'         => 'utf8_unicode_ci',
        'options'           => [
            PDO::ATTR_EMULATE_PREPARES   => false,
        ],
        'reconnect_timeout' => 3600
    ]);

    return $conn->getQueryBuilder();
});

$di->setShared('storage', function () {
    return new Storage();
});