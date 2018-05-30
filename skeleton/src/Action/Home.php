<?php

namespace App\Action;

use App\Menu\MenuManager;
use App\Security\CustomVoter;
use App\Services\Library;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class Home extends Controller
{
    /**
     * @Route("/", name="home")
     * @param Library $library
     * @param UserInterface $user
     * @return JsonResponse
     */
    public function __invoke(Request $request, Library $library, UserInterface $user)
    {
        $this->denyAccessUnlessGranted(CustomVoter::CRITERIA, $library);

        return new JsonResponse([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Action/HomeController.php',
            'book' => $library->takeBook(),
            'user' => $user->getUsername(),
            'session UserName' => $request->getSession()->get('username'),
        ]);
    }
//
//    /**
//     * @Route("/html", name="home_html")
//     *
//     * @param Profiler $profiler
//     * @param MenuManager $menuManager
//     * @throws \InvalidArgumentException
//     *
//     * @return Response
//     */
//    public function indexAction(Profiler $profiler, MenuManager $menuManager): Response
//    {
//        $menu = $menuManager->getMenu();
//        dump($menu);
//
//        $response = new Response('<html><body>Welcome to the HTML controller!</body></html>');
//
//        ['token' => $token] = $profiler->find('', '', 1, '', '', '')[0];
//        $profile = $profiler->loadProfile($token);
//
//        dump($token);
//        dump($profile);
//
//        return $response;
//    }
}
