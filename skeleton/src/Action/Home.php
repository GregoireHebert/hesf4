<?php

namespace App\Action;

use App\Services\Library;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Routing\Annotation\Route;

class Home
{
    /**
     * @Route("/", name="home")
     * @param Library $library
     * @return JsonResponse
     */
    public function __invoke(Library $library)
    {
        return new JsonResponse([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Action/HomeController.php',
            'book' => $library->takeBook(),
        ]);
    }

    /**
     * @Route("/html", name="home_html")
     *
     * @param Profiler $profiler
     * @throws \InvalidArgumentException
     *
     * @return Response
     */
    public function indexAction(Profiler $profiler): Response
    {
        $response = new Response('<html><body>Welcome to the HTML controller!</body></html>');

        ['token' => $token] = $profiler->find('', '', 1, '', '', '')[0];
        $profile = $profiler->loadProfile($token);

        dump($token);
        dump($profile);

        return $response;
    }
}
