<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\StockSalesConnector\Communication\Plugin;

use Generated\Shared\Transfer\StockProductTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\StockSalesConnector\Business\StockSalesConnectorCommunicationFactory getFactory()
 */
class UpdateStockPlugin extends AbstractPlugin
{

    // TODO not sure this Connector/Plugin will be needed after refactor sales Bundle!

    /**
     * @param string $sku
     * @param string $stockType
     * @param int $incrementBy
     *
     * @return void
     */
    public function incrementStockProduct($sku, $stockType, $incrementBy = 1)
    {
        $this->getFactory()->getStockFacade()->incrementStockProduct($sku, $stockType, $incrementBy);
    }

    /**
     * @param string $sku
     * @param string $stockType
     * @param int $decrementBy
     *
     * @return void
     */
    public function decrementStockProduct($sku, $stockType, $decrementBy = 1)
    {
        $this->getFactory()->getStockFacade()->decrementStockProduct($sku, $stockType, $decrementBy);
    }

    /**
     * @param \Generated\Shared\Transfer\StockProductTransfer $transferStockProduct
     *
     * @return int
     */
    public function updateStockProduct(StockProductTransfer $transferStockProduct)
    {
        return $this->getFactory()->getStockFacade()->updateStockProduct($transferStockProduct);
    }

}
