<?php

namespace App\Action;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Cache extends Controller
{
    /**
     * @Route("/cached", name="cached")
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $content = $this->renderView('static/neverChange.html.twig');

        $response = new Response($content);
        $response->setSharedMaxAge(10);

        return $response;
    }

    /**
     * @Route("/dyn", name="dyn")
     * @return Response
     */
    public function dyn(Request $request)
    {
        $content = $this->renderView('Dynamic/dynamic.html.twig');

        $response = new Response($content);
        $response->setSharedMaxAge(5);

        return $response;
    }
}
