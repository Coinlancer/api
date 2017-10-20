<?php

error_reporting(E_ALL);

declare(ticks = 1);

define('APP_PATH', realpath(__DIR__ . '/../..') . '/');
define('CONFIG_PATH', APP_PATH . 'common/config/');
define('MODEL_PATH', APP_PATH . 'common/models/');
define('TEMP_PATH', APP_PATH . 'temp/');

class CliApplication
{
    protected function _registerServices()
    {
        # Register config
        $config = require_once(CONFIG_PATH . 'config.php');

        $loader = new \Phalcon\Loader();

        # Register tasks
        $loader->registerDirs([
            APP_PATH . 'app/cli/tasks/',
        ]);

        # Register common namespaces
        $loader->registerNamespaces([
            'App\Models' => APP_PATH . 'common/models',
            'App\Lib'    => APP_PATH . 'common/lib',
        ]);

        $loader->register();


        $di = new Phalcon\Di\FactoryDefault\Cli;

        require_once(CONFIG_PATH . 'services.php');

        return $di;
    }

    public function __construct()
    {
        global $argv;

        # Require composer autoload
        require_once APP_PATH . 'vendor/autoload.php';

        $console = new Phalcon\Cli\Console;
        $di = $this->_registerServices();

        $arguments = [
            'params' => []
        ];

        foreach ($argv as $k => $arg) {
            if ($k == 1) {
                $arguments['task'] = $arg;
            } elseif ($k == 2) {
                $arguments['action'] = $arg;
            } elseif ($k >= 3) {
                $arguments['params'][] = $arg;
            }
        }

        if (in_array('-v', $arguments['params'])) {
            $di->setShared('verbose', function () {
                return true;
            });
        }

        $console->setDI($di);

        define('CURRENT_TASK', $arguments['task'] ?? null);
        define('CURRENT_ACTION', $arguments['action'] ?? null);

        if (!in_array('-c', $arguments['params'])) {
            $this->isAlreadyRunning();
        }

        try {
            $console->handle($arguments);
        } catch (\Phalcon\Exception $e) {
            echo $e->getMessage();
            exit(255);
        }
    }

    private function isAlreadyRunning()
    {
        $lock_path = sys_get_temp_dir();

        # Check file lock
        if (!is_writable($lock_path)) {
            die($lock_path . ' IS NOT READABLE! Cannot PROCEED' . PHP_EOL);
        }

        $lockfile = $lock_path . '/' . md5(__FILE__ . strtolower(CURRENT_TASK . CURRENT_ACTION)) . '.lock';

        # Check if the script is running
        $handler = fopen($lockfile, 'c');
        if (!$handler) {
            throw new Exception("Cannot open lockfile");
        }

        if(!flock($handler, LOCK_EX | LOCK_NB)) {
            $info = json_decode(file_get_contents($lockfile), true);
            $runtime = round((time() - $info['start']) / 60);
            echo 'Process: ' . CURRENT_TASK . '/' . CURRENT_ACTION . ' ['.$info['pid'].'] is running for ' . $runtime . ' minutes.' . PHP_EOL;
            exit;
        }

        $info = [
            'pid'   =>  posix_getpid(),
            'start' =>  time(),
        ];

        ftruncate($handler, 0);
        fwrite($handler, json_encode($info));

        # Remove pid on shutdown
        register_shutdown_function(function () use ($handler, $lockfile) {
            fclose($handler);
            unlink($lockfile);
        });
    }
}

$application = new CliApplication();