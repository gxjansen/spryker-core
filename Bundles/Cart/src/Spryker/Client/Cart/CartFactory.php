<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Client\Cart;

use Spryker\Client\Cart\Zed\CartStub;
use Spryker\Client\Cart\Session\CartSession;
use Spryker\Client\Kernel\AbstractFactory;

class CartFactory extends AbstractFactory
{

    /**
     * @return \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    public function createSession()
    {
        return new CartSession($this->createSessionClient());
    }

    /**
     * @return \Spryker\Client\Cart\Zed\CartStubInterface
     */
    public function createZedStub()
    {
        return new CartStub($this->createZedRequestClient());
    }

}
