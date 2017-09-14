<?php

namespace Marlosoft\Test\Silex\Routing\Annotation\Controllers;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;

/**
 * Class AnnotationRoutingController
 * @package Marlosoft\Test\Silex\Routing\Annotation\Controllers
 */
class AnnotationRoutingController
{
    /**
     * @Route("/index")
     * @Route("/index/index", methods={"GET"})
     *
     * @return Response
     */
    public function indexAction()
    {
        return new Response();
    }

    /**
     * @Route("/post", methods={"POST"})
     *
     * @return Response
     */
    public function postAction()
    {
        return new Response();
    }

    /**
     * @Route(
     *     "/comment/{data}",
     *      requirements={"data" = "\d+",}
     * )
     *
     * @return Response
     */
    public function defaultsAction()
    {
        return new Response();
    }
}
