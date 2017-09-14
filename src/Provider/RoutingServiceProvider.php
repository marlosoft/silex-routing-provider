<?php

namespace Marlosoft\Silex\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Routing\AnnotatedRouteControllerLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RoutingServiceProvider
 * @package Marlosoft\Silex\Provider
 */
class RoutingServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['routes'] = $app->extend('routes', function (RouteCollection $routes) use ($app) {
            $locator = new FileLocator();
            $reader = new AnnotationReader();

            if (isset($app['routes.cache'])) {
                $reader = new CachedReader($reader, $app['routes.cache'], $app['debug']);
            }

            $loader = new AnnotatedRouteControllerLoader($reader);
            $directoryLoader = new AnnotationDirectoryLoader($locator, $loader);

            foreach ($app['routes.directories'] as $directory) {
                $collection = $directoryLoader->load($directory);
                $routes->addCollection($collection);
            }

            return $routes;
        });
    }
}
