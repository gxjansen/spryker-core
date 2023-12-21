<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Security\Subscriber;

use Spryker\Service\Container\ContainerInterface;
use Spryker\Yves\Security\Configurator\SecurityConfiguratorInterface;

class SecurityDispatcherSubscriber implements SecurityDispatcherSubscriberInterface
{
    /**
     * @var string
     */
    protected const SERVICE_SECURITY_FIREWALL = 'security.firewall';

    /**
     * @uses \Spryker\Yves\EventDispatcher\Plugin\Application\EventDispatcherApplicationPlugin::SERVICE_DISPATCHER
     *
     * @var string
     */
    protected const SERVICE_DISPATCHER = 'dispatcher';

    /**
     * @var \Spryker\Yves\Security\Configurator\SecurityConfiguratorInterface
     */
    protected SecurityConfiguratorInterface $securityConfigurator;

    /**
     * @param \Spryker\Yves\Security\Configurator\SecurityConfiguratorInterface $securityConfigurator
     */
    public function __construct(SecurityConfiguratorInterface $securityConfigurator)
    {
        $this->securityConfigurator = $securityConfigurator;
    }

    /**
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return void
     */
    public function addSubscriber(ContainerInterface $container): void
    {
        /** @var \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher */
        $dispatcher = $container->get(static::SERVICE_DISPATCHER);
        $dispatcher->addSubscriber($container->get(static::SERVICE_SECURITY_FIREWALL));

        $eventSubscribers = $this->securityConfigurator->getSecurityConfiguration($container)->getEventSubscribers();

        foreach ($eventSubscribers as $eventSubscriber) {
            $dispatcher->addSubscriber(call_user_func($eventSubscriber, $container));
        }
    }
}
