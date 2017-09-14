Silex Routing Service Provider
==============================

Routing service provider for silex micro-framework using annotations.
This uses `sensio/framework-extra-bundle` and `doctrine/common` libraries
to use annotation for routing just like in Symfony2 framework.

## Installation
* Use composer
    ```bash
    composer require marlosoft/silex-routing-provider
    ```

## Usage
1. Add Doctrine's annotation registry loader to autoload
    ```php
    use Doctrine\Common\Annotations\AnnotationRegistry;
 
    $autoload = require('/path/to/vendor/autoload.php');
    AnnotationRegistry::registerLoader([$autoload, 'loadClass']);
    ```

2. Register the service provider to your application
    ```php
    use Marlosoft\Silex\Provider\RoutingServiceProvider;
 
    $app = new Application();
    $app->register(new RoutingServiceProvider(), [
      'routes.directories' => ['/path/to/controllers/directory/']
    ]);
    ```

## Options

* `routes.directories` (required) is an array of directory paths where the annotations are evaluated 
* `routes.cache` (optional) is the cache object that will be used to store the evaluated annotations.  
This is recommended in production deployments. Cache objects that can use used are `FilesystemCache` or `ApcuCache`
