Installation
============


**Proof of Concept - NOT YET USABLE!!!**

**First usable version around 2017-03-01**

Introduction
------------

**This is Symfony Bundle to access REST API for [Wrike](https://www.wrike.com/) online project management software tool.**

For general purpose SDK please check [full configured Wrike PHP SDK](https://github.com/zibios/wrike-php-sdk).
For none standard purposes please check [generic Wrike PHP Library](https://github.com/zibios/wrike-php-library).

Project status
--------------

[![Packagist License](https://img.shields.io/packagist/l/zibios/wrike-bundle.svg)](https://packagist.org/packages/zibios/wrike-bundle)
[![Packagist Downloads](https://img.shields.io/packagist/dt/zibios/wrike-bundle.svg)](https://packagist.org/packages/zibios/wrike-bundle)
[![Packagist Version](https://img.shields.io/packagist/v/zibios/wrike-bundle.svg)](https://packagist.org/packages/zibios/wrike-bundle)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zibios/wrike-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zibios/wrike-bundle/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4923a860-32a0-474a-887f-7766d8407b88/mini.png)](https://insight.sensiolabs.com/projects/4923a860-32a0-474a-887f-7766d8407b88)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/bddb2d36ac0943618178a65984252b12)](https://www.codacy.com/app/zibios/wrike-bundle)
[![Test Coverage](https://codeclimate.com/github/zibios/wrike-bundle/badges/coverage.svg)](https://codeclimate.com/github/zibios/wrike-bundle/coverage)
[![Build Status](https://travis-ci.org/zibios/wrike-bundle.svg?branch=master)](https://travis-ci.org/zibios/wrike-bundle)
[![Libraries.io](https://img.shields.io/librariesio/github/zibios/wrike-bundle.svg)](https://libraries.io/packagist/zibios%2Fwrike-bundle)

[All badges](Resources/doc/Badges.md)


Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require zibios/wrike-bundle "dev-master"
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

            new Zibios\Bundle\WrikeBundle\ZibiosWrikeBundle(),
        );

        // ...
    }

    // ...
}
```



Reference
---------

[Generic Wrike PHP Library](https://github.com/zibios/wrike-php-library)

[Response transformer plugin](https://github.com/zibios/wrike-php-jmsserializer) for Wrike PHP Library

[HTTP Client plugin](https://github.com/zibios/wrike-php-guzzle) for Wrike PHP Library


Official [Wrike API Documentation](https://developers.wrike.com/documentation/api/overview)

License
-------

This bundle is available under the [MIT license](LICENSE).
