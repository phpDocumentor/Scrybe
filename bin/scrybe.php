<?php
// only load the autoloader if it is there; if not we are a package
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__.'/../vendor/autoload.php';
}

$app = new \phpDocumentor\Scrybe\Application();
$app->run();