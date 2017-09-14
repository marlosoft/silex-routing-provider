<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

$autoload = require(dirname(__DIR__) . '/vendor/autoload.php');
AnnotationRegistry::registerLoader([$autoload, 'loadClass']);

require(__DIR__ . '/cases/Controllers/AnnotationRoutingController.php');
