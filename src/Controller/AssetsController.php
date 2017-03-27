<?php

namespace antoligy\GlobalAssetsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class AssetsController
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param Twig_Environment $twig Twig Environment, preconfigured by Symfony.
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
        $this->response = new Response();

        $this->response->setPublic();
        $this->response->setSharedMaxAge(3600);
        $this->response->setVary('Accept-Encoding');
    }

    /**
     * Renders a block from a given template through ESI.
     * Note: This relies upon Symfony's salted fragment handling,
     * else it is possible to spoof the location of a dodgy template.
     *
     * @param string $blk Twig Block to render, containing assets.
     * @param string $tpl Twig Template to render, containing our block.
     */
    public function assetsAction($blk, $tpl)
    {
        $content = $this->twig->loadTemplate($tpl)->renderBlock($blk, []);
        $this->response->setContent($content);
        return $this->response;
    }
}