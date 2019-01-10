<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/home", name="home")
 */
class Home
{
    private $profiler;

    public function __construct(Profiler $profiler)
    {
        $this->profiler = $profiler;
    }

    public function __invoke()
    {
        $response = new Response('<html><body>Welcome to the HTML controller!</body></html>');

        ['token' => $token] = $this->profiler->find('', '', 1, '', '', '')[0];
        $profile = $this->profiler->loadProfile($token);

        dump($token);
        dump($profile);

        return $response;
    }
}
