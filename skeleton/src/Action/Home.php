<?php

namespace App\Action;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Home
{
    /**
     * @Route("/", name="home")
     */
    public function __invoke()
    {
        return new JsonResponse([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Action/HomeController.php',
        ]);
    }

    /**
     * @Route("/html", name="home_html")
     *
     * @throws \InvalidArgumentException
     */
    public function indexAction(): Response
    {
        return new Response('<html><body>Welcome to the HTML controller!</body></html>');
    }
}
