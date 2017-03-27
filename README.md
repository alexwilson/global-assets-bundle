## Global Assets Bundle ##

The Global Assets Bundle introduces a new Twig block, `{% globalassets %}`, allowing for specific groups of assets to be isolated from the rest of a page.  This is useful for allowing content shared between all pages, specifically JavaScript/CSS dependencies, to expire separately to the rest of the page making long-tail content easier to cache.

Note: This can all currently be manually accomplished using a render_esi tag pointing a controller, however the purpose of this bundle is to save on duplicating this work potentially multiple times per project.

[Other planned features](./TODO.md) include asset inlining and the ability to support HTTP2 server push.

Example Usage
=============

```twig
{% globalassets frontend_head %}
    <!-- Styles -->
    <link href="{{ webpack_asset('@FooBundle/Resources/assets/main.js', 'css') }}" rel="stylesheet"></link>

    <!-- Scripts -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
    <script type="text/javascript" src="{{ webpack_asset('@FooBundle/Resources/assets/main.js', 'js') }}"></script>
{% endglobalassets %}
```


Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require antoligy/global-assets-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new antoligy\GlobalAssetsBundle\antoligyGlobalAssetsBundle(),
        );

        // ...
    }

    // ...
}
```
