<?php
/*
 * Copyright (c) 2016 KUBO Atsuhiro <kubo@iteman.jp>,
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
     * @var string
     */
    private $copyAs;

    /**
     * {@inheritdoc}
     */
    public function import($resource, $type = null, $ignoreErrors = false, $sourceResource = null)
    {
        $routeCollection = parent::import($resource, $type, $ignoreErrors, $sourceResource);
        if ($this->copyAs !== null) {
            foreach ($routeCollection->all() as $name => $route) {
                $routeCollection->add($this->copyAs.$name, $route);
                $routeCollection->remove($name);
            }

            $this->copyAs = null;
        }

        return $routeCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function load($file, $type = null)
    {
        $availableKeysProperty = new \ReflectionProperty(\Symfony\Component\Routing\Loader\YamlFileLoader::class, 'availableKeys');
        $availableKeysProperty->setAccessible(true);
        $availableKeys = $availableKeysProperty->getValue();
        if (!in_array('copy_as', $availableKeys)) {
            $availableKeys[] = 'copy_as';
            $availableKeysProperty->setValue(null, $availableKeys);
        }
        $availableKeysProperty->setAccessible(false);

        return parent::load($file, $type);
    }

    /**
     * {@inheritdoc}
     */
    protected function parseImport(RouteCollection $collection, array $config, $path, $file)
    {
        $this->copyAs = isset($config['copy_as']) ? $config['copy_as'] : null;

        parent::parseImport($collection, $config, $path, $file);
    }
}
