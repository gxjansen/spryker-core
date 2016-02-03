<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\OmsCheckoutConnector\Communication\Plugin;

use Generated\Shared\Transfer\CheckoutRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Checkout\Dependency\Plugin\CheckoutOrderHydrationInterface;

/**
 * @method \Spryker\Zed\OmsCheckoutConnector\Business\OmsCheckoutConnectorFacade getFacade()
 * @method \Spryker\Zed\OmsCheckoutConnector\Communication\OmsCheckoutConnectorCommunicationFactory getFactory()
 */
class OrderOmsHydrationPlugin extends AbstractPlugin implements CheckoutOrderHydrationInterface
{

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\CheckoutRequestTransfer $checkoutRequest
     *
     * @return void
     */
    public function hydrateOrder(OrderTransfer $orderTransfer, CheckoutRequestTransfer $checkoutRequest)
    {
        $this->getFacade()->hydrateOrderTransfer($orderTransfer, $checkoutRequest);
    }

}
