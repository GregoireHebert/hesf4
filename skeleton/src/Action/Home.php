<?php

namespace App\Action;

use App\Services\Library;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Routing\Annotation\Route;

class Home
{
    private $profiler;
    private $book;

    public function __construct(Profiler $profiler, Library $library)
    {
        $this->profiler = $profiler;
        $this->book = $library->takeBook();
    }

    /**
     * @Route("/", name="home")
     */
    public function __invoke()
    {
        return new JsonResponse([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Action/HomeController.php',
            'book' => $this->book,
        ]);
    }

    /**
     * @Route("/html", name="home_html")
     *
     * @throws \InvalidArgumentException
     */
    public function indexAction(): Response
    {
        $response = new Response('<html><body>Welcome to the HTML controller!</body></html>');

        ['token' => $token] = $this->profiler->find('', '', 1, '', '', '')[0];
        $profile = $this->profiler->loadProfile($token);

        dump($token);
        dump($profile);

        return $response;
    }
}
