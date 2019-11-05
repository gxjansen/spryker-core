<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CartCodesRestApi\Business;

use Spryker\Zed\CartCodesRestApi\Business\CartCodeAdder\CartCodeAdder;
use Spryker\Zed\CartCodesRestApi\Business\CartCodeAdder\CartCodeAdderInterface;
use Spryker\Zed\CartCodesRestApi\Business\CartCodeDeleter\CartCodeDeleter;
use Spryker\Zed\CartCodesRestApi\Business\CartCodeDeleter\CartCodeDeleterInterface;
use Spryker\Zed\CartCodesRestApi\CartCodesRestApiDependencyProvider;
use Spryker\Zed\CartCodesRestApi\Dependency\Facade\CartCodesRestApiToCartCodeFacadeInterface;
use Spryker\Zed\CartCodesRestApi\Dependency\Facade\CartCodesRestApiToCartsRestApiFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Spryker\Zed\CartCodesRestApi\CartCodesRestApiConfig getConfig()
 */
class CartCodesRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\CartCodesRestApi\Business\CartCodeAdder\CartCodeAdderInterface
     */
    public function createCartCodeAdder(): CartCodeAdderInterface
    {
        return new CartCodeAdder(
            $this->getCartCodeFacade(),
            $this->getCartsRestApiFacade()
        );
    }

    /**
     * @return \Spryker\Zed\CartCodesRestApi\Business\CartCodeDeleter\CartCodeDeleterInterface
     */
    public function createCartCodeDeleter(): CartCodeDeleterInterface
    {
        return new CartCodeDeleter(
            $this->getCartCodeFacade(),
            $this->getCartsRestApiFacade()
        );
    }

    /**
     * @return \Spryker\Zed\CartCodesRestApi\Dependency\Facade\CartCodesRestApiToCartCodeFacadeInterface
     */
    public function getCartCodeFacade(): CartCodesRestApiToCartCodeFacadeInterface
    {
        return $this->getProvidedDependency(CartCodesRestApiDependencyProvider::FACADE_CART_CODE);
    }

    /**
     * @return \Spryker\Zed\CartCodesRestApi\Dependency\Facade\CartCodesRestApiToCartsRestApiFacadeInterface
     */
    public function getCartsRestApiFacade(): CartCodesRestApiToCartsRestApiFacadeInterface
    {
        return $this->getProvidedDependency(CartCodesRestApiDependencyProvider::FACADE_CARTS_REST_API);
    }
}
