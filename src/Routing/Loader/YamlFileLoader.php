<?php
/*
 * Copyright (c) KUBO Atsuhiro <kubo@iteman.jp>,
 * All rights reserved.
 *
 * This file is part of PHPMentorsRouteTemplatingBundle.
 *
 * This program and the accompanying materials are made available under
 * the terms of the BSD 2-Clause License which accompanies this
 * distribution, and is available at http://opensource.org/licenses/BSD-2-Clause
 */

namespace PHPMentors\RouteTemplatingBundle\Routing\Loader;

use Symfony\Component\Routing\RouteCollection;

class YamlFileLoader extends \Symfony\Component\Routing\Loader\YamlFileLoader
{
    /**
     * @var array
     */
    private $copyAs = [];

    /**
     * {@inheritdoc}
     */
    public function import($resource, string $type = null, bool $ignoreErrors = false, string $sourceResource = null, $exclude = null)
    {
        $routeCollection = parent::import($resource, $type, $ignoreErrors, $sourceResource);
        $copyAs = $this->copyAs[count($this->copyAs) - 1];
        if ($copyAs !== null) {
            foreach ($routeCollection->all() as $name => $route) {
                $routeCollection->add($copyAs.$name, $route);
                $routeCollection->remove($name);
            }
        }

        array_pop($this->copyAs);

        return $routeCollection;
    }

    /**
     * {@inheritdoc}
     */
    protected function parseImport(RouteCollection $collection, array $config, string $path, string $file)
    {
        $this->copyAs[] = isset($config['options']['copy_as']) ? $config['options']['copy_as'] : null;

        parent::parseImport($collection, $config, $path, $file);
    }
}
