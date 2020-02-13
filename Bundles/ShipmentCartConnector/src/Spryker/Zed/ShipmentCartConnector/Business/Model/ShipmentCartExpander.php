<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShipmentCartConnector\Business\Model;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Spryker\Shared\ShipmentCartConnector\ShipmentCartConnectorConfig;
use Spryker\Zed\ShipmentCartConnector\Business\Applier\SourcePriceApplierInterface;
use Spryker\Zed\ShipmentCartConnector\Dependency\Facade\ShipmentCartConnectorToPriceFacadeInterface;
use Spryker\Zed\ShipmentCartConnector\Dependency\Facade\ShipmentCartConnectorToShipmentFacadeInterface;

/**
 * @deprecated Use \Spryker\Zed\ShipmentCartConnector\Business\Cart\ShipmentCartExpander instead.
 */
class ShipmentCartExpander implements ShipmentCartExpanderInterface
{
    /**
     * @var \Spryker\Zed\ShipmentCartConnector\Dependency\Facade\ShipmentCartConnectorToShipmentFacadeInterface
     */
    protected $shipmentFacade;

    /**
     * @var \Spryker\Zed\ShipmentCartConnector\Dependency\Facade\ShipmentCartConnectorToPriceFacadeInterface
     */
    protected $priceFacade;

    /**
     * @var \Spryker\Zed\ShipmentCartConnector\Business\Applier\SourcePriceApplierInterface
     */
    protected $sourcePriceApplier;

    /**
     * @param \Spryker\Zed\ShipmentCartConnector\Dependency\Facade\ShipmentCartConnectorToShipmentFacadeInterface $shipmentFacade
     * @param \Spryker\Zed\ShipmentCartConnector\Dependency\Facade\ShipmentCartConnectorToPriceFacadeInterface $priceFacade
     * @param \Spryker\Zed\ShipmentCartConnector\Business\Applier\SourcePriceApplierInterface $sourcePriceApplier
     */
    public function __construct(
        ShipmentCartConnectorToShipmentFacadeInterface $shipmentFacade,
        ShipmentCartConnectorToPriceFacadeInterface $priceFacade,
        SourcePriceApplierInterface $sourcePriceApplier
    ) {
        $this->shipmentFacade = $shipmentFacade;
        $this->priceFacade = $priceFacade;
        $this->sourcePriceApplier = $sourcePriceApplier;
    }

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function updateShipmentPrice(CartChangeTransfer $cartChangeTransfer)
    {
        $quoteTransfer = $cartChangeTransfer->getQuote();

        if (!$this->shipmentExpenseNeedsUpdate($quoteTransfer)) {
            return $cartChangeTransfer;
        }

        $idShipmentMethod = $quoteTransfer->getShipment()->getMethod()->getIdShipmentMethod();

        $shipmentMethodTransfer = $this->shipmentFacade->findAvailableMethodById($idShipmentMethod, $quoteTransfer);

        if (!$shipmentMethodTransfer) {
            return $cartChangeTransfer;
        }

        $shipmentMethodTransfer->setCurrencyIsoCode($quoteTransfer->getCurrency()->getCode());
        $shipmentMethodTransfer->setSourcePrice($quoteTransfer->getShipment()->getMethod()->getSourcePrice());

        $this->updateShipmentExpenses($quoteTransfer, $shipmentMethodTransfer);

        $quoteTransfer->getShipment()->setMethod($shipmentMethodTransfer);

        return $cartChangeTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function shipmentExpenseNeedsUpdate(QuoteTransfer $quoteTransfer): bool
    {
        return $quoteTransfer->getShipment()
            && $this->isCurrencyChanged($quoteTransfer)
            || !$quoteTransfer->getShipment()->getMethod()->getSourcePrice();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isCurrencyChanged(QuoteTransfer $quoteTransfer)
    {
        if (!$quoteTransfer->getShipment()->getMethod()) {
            return false;
        }

        $shipmentCurrencyIsoCode = $quoteTransfer->getShipment()->getMethod()->getCurrencyIsoCode();
        if ($shipmentCurrencyIsoCode !== $quoteTransfer->getCurrency()->getCode()) {
            return true;
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\ExpenseTransfer $shipmentExpenseTransfer
     * @param \Generated\Shared\Transfer\ShipmentMethodTransfer $shipmentMethodTransfer
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     * @param string $priceMode
     *
     * @return void
     */
    protected function setExpensePrice(
        ExpenseTransfer $shipmentExpenseTransfer,
        ShipmentMethodTransfer $shipmentMethodTransfer,
        CurrencyTransfer $currencyTransfer,
        $priceMode
    ) {

        $netModeIdentifier = $this->priceFacade->getNetPriceModeIdentifier();
        foreach ($shipmentMethodTransfer->getPrices() as $moneyValueTransfer) {
            if ($moneyValueTransfer->getCurrency()->getCode() !== $currencyTransfer->getCode()) {
                continue;
            }

            $moneyValueTransfer = $this->sourcePriceApplier->applySourcePrices($moneyValueTransfer, $shipmentMethodTransfer);

            if ($priceMode === $netModeIdentifier) {
                $shipmentExpenseTransfer->setUnitGrossPrice(0);
                $shipmentExpenseTransfer->setUnitNetPrice($moneyValueTransfer->getNetAmount());

                return;
            }

            $shipmentExpenseTransfer->setUnitNetPrice(0);
            $shipmentExpenseTransfer->setUnitGrossPrice($moneyValueTransfer->getGrossAmount());

            return;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\ShipmentMethodTransfer $shipmentMethodTransfer
     *
     * @return void
     */
    protected function updateShipmentExpenses(QuoteTransfer $quoteTransfer, ShipmentMethodTransfer $shipmentMethodTransfer)
    {
        $priceMode = $quoteTransfer->getPriceMode();
        $currencyTransfer = $quoteTransfer->getCurrency();
        foreach ($quoteTransfer->getExpenses() as $expenseTransfer) {
            if ($expenseTransfer->getType() !== ShipmentCartConnectorConfig::SHIPMENT_EXPENSE_TYPE) {
                continue;
            }

            $this->setExpensePrice($expenseTransfer, $shipmentMethodTransfer, $currencyTransfer, $priceMode);
        }
    }
}
