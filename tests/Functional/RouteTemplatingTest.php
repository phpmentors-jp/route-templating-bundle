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

namespace PHPMentors\RouteTemplatingBundle\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\RouteCollection;

/**
 * @since Class available since Release 1.1.0
 */
class RouteTemplatingTest extends KernelTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $_SERVER['KERNEL_DIR'] = __DIR__.'/app';
        require_once $_SERVER['KERNEL_DIR'].'/AppKernel.php';
        $_SERVER['KERNEL_CLASS'] = 'AppKernel';

        $this->removeCacheDir();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->removeCacheDir();
    }

    /**
     * {@inheritdoc}
     */
    protected static function createKernel(array $options = array())
    {
        $kernel = KernelTestCase::createKernel($options);
        if (array_key_exists('config', $options)) {
            $kernel->setConfig($options['config']);
        }

        return $kernel;
    }

    protected function removeCacheDir()
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove($_SERVER['KERNEL_DIR'].'/cache/test');
    }

    /**
     * @test
     */
    public function copyAllRoutesWithSpecifiedPrefix()
    {
        static::bootKernel(array('config' => function (ContainerBuilder $container) {
            $container->loadFromExtension('framework', array(
                'secret' => '$ecret',
            ));
        }));

        $routeCollection = static::$kernel->getContainer()->get('router')->getRouteCollection(); /* @var RouteCollection $routeCollection */

        $this->assertThat($routeCollection->count(), $this->equalTo(4));

        $routeA = $routeCollection->get('a');
        $routeB = $routeCollection->get('b');
        $copiedRouteA = $routeCollection->get('foo_a');
        $copiedRouteB = $routeCollection->get('foo_b');
        $pathPrefix = '/foo';

        $this->assertThat($copiedRouteA->getPath(), $this->equalTo($pathPrefix.$routeA->getPath()));
        $this->assertThat($copiedRouteB->getPath(), $this->equalTo($pathPrefix.$routeB->getPath()));
    }
}
