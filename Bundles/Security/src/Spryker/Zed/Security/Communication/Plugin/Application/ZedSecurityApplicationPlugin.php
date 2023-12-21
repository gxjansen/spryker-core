<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Security\Communication\Plugin\Application;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface;
use Spryker\Shared\ApplicationExtension\Dependency\Plugin\BootableApplicationPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\Security\Communication\SecurityCommunicationFactory getFactory()
 * @method \Spryker\Zed\Security\SecurityConfig getConfig()()
 * @method \Spryker\Zed\Security\Business\SecurityFacadeInterface getFacade()
 */
class ZedSecurityApplicationPlugin extends AbstractPlugin implements ApplicationPluginInterface, BootableApplicationPluginInterface
{
    /**
     * {@inheritDoc}
     * - Adds event subscribers to the event dispatcher.
     * - Adds a custom router to the container to handle security-related routes.
     * - Executes the stack of {@link \Spryker\Shared\SecurityExtension\Dependency\Plugin\SecurityPluginInterface} plugins.
     *
     * @api
     *
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    public function boot(ContainerInterface $container): ContainerInterface
    {
        $this->getFactory()->createSecurityApplicationBooter()->boot($container);

        return $container;
    }

    /**
     * {@inheritDoc}
     * - Integrates with the Symfony framework, leveraging its security components for managing authentication and authorization.
     * - Configures and provides necessary services for security-related functionality.
     * - Executes the stack of {@link \Spryker\Shared\SecurityExtension\Dependency\Plugin\SecurityPluginInterface} plugins.
     * - Executes the stack of {@link \Spryker\Shared\SecurityExtension\Dependency\Plugin\SecurityAuthenticationListenerFactoryTypeExpanderPluginInterface} plugins.
     *
     * @api
     *
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Service\Container\ContainerInterface
     */
    public function provide(ContainerInterface $container): ContainerInterface
    {
        return $this->getFactory()->createServicesLoader()->provide($container);
    }
}
