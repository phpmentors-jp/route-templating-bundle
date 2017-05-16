# PHPMentorsRouteTemplatingBundle

A Symfony bundle for route templating

[![Total Downloads](https://poser.pugx.org/phpmentors/route-templating-bundle/downloads)](https://packagist.org/packages/phpmentors/route-templating-bundle)
[![Latest Stable Version](https://poser.pugx.org/phpmentors/route-templating-bundle/v/stable)](https://packagist.org/packages/phpmentors/route-templating-bundle)
[![Latest Unstable Version](https://poser.pugx.org/phpmentors/route-templating-bundle/v/unstable)](https://packagist.org/packages/phpmentors/route-templating-bundle)

## Features

* Route templating
  * Copy all routes defined in the imported resource with the specified prefix

## Installation

`PHPMentorsRouteTemplatingBundle` can be installed using [Composer](http://getcomposer.org/).

First, add the dependency to `phpmentors/route-templating-bundle` into your `composer.json` file as the following:

**Stable version:**

```
composer require phpmentors/route-templating-bundle "1.0.*"
```

**Development version:**

```
composer require phpmentors/route-templating-bundle "1.0.*"
```

Second, add `PHPMentorsRouteTemplatingBundle` into your bundles to register in `AppKernel::registerBundles()` as the following:

```php
...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new PHPMentors\RouteTemplatingBundle\PHPMentorsRouteTemplatingBundle(),
        );
        ...
```

## Configuration

`app/config/routing.yml:`

```yaml
# ...

photos:
    resource: "@PhotoBundle/Resources/config/routing.yml"
    prefix:   /photos

admin_photos:
    resource: "@PhotoBundle/Resources/config/routing.yml" # Same resource as `photos`
    prefix:   /admin/photos
    copy_as: admin_
```

## Support

If you find a bug or have a question, or want to request a feature, create an issue or pull request for it on [Issues](https://github.com/phpmentors-jp/route-templating-bundle/issues).

## Copyright

Copyright (c) 2016-2017 KUBO Atsuhiro, All rights reserved.

## License

[The BSD 2-Clause License](http://opensource.org/licenses/BSD-2-Clause)
