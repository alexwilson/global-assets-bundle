<?php

namespace antoligy\GlobalAssetsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AssetsController
{

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function assetsAction(
        Request $request,
        $blk,
        $tpl
    ) {
        $content = $this->twig->loadTemplate($tpl)->renderBlock($blk, []);
        $response = new Response($content);
        return $response;
    }
}