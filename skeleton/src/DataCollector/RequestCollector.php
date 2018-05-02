<?php

declare(strict_types=1);

namespace App\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestCollector extends DataCollector
{
    public function collect(Request $request, Response $response, \Exception $exception = null): void
    {
        $this->data = array(
            'method' => $request->getMethod(),
            'acceptable_content_types' => $request->getAcceptableContentTypes(),
        );
    }

    public function getName(): string
    {
        return 'app.request_collector';
    }

    public function reset(): void
    {
        $this->data = [];
    }

    public function getMethod()
    {
        return $this->data['method'];
    }

    public function getAcceptableContentTypes()
    {
        return $this->data['acceptable_content_types'];
    }

    public function getLoadedAdverts()
    {
        return ['AXA', 'Babbel', 'Leroy Merlin'];
    }
}
