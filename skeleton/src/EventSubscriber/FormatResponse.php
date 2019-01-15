<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Twig\Environment;

class FormatResponse implements EventSubscriberInterface
{
    private $twig;
    private $serializer;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public static function getSubscribedEvents()
    {
        return [
//            KernelEvents::VIEW => 'response',
//            KernelEvents::RESPONSE => 'type'
        ];
    }

    public function type(FilterResponseEvent $event)
    {
        if ('json' === $event->getRequest()->getRequestFormat()) {
            $response = $event->getResponse();
            $response->headers->set('content-type', 'application/json');
        }
    }

    public function response(GetResponseForControllerResultEvent $event)
    {
        $menu = $event->getControllerResult();
        $response = new Response();

        if ('json' === $event->getRequest()->getRequestFormat()) {
            $response->setContent(
                $this->serializer->serialize($menu, 'json')
            );
        } else {
            $response->setContent(
               $this->twig->render('menu.html.twig', ['menu' => $menu])
            );
        }

        $event->setResponse($response);
    }
}
