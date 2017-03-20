<?php

namespace antoligy\GlobalAssetsBundle\Twig;

use Twig_Extension;

class GlobalAssetsExtension extends Twig_Extension
{
    public function getTokenParsers()
    {
        return array(new GlobalAssetsTagTokenParser());
    }
}