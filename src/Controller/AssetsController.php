<?php

namespace antoligy\GlobalAssetsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class AssetsController
{
    public function __invoke()
    {
        return $this->renderAssetsAction();
    }

    public function renderAssetsAction()
    {
        $response = new Response();
        return $response;
    }
}