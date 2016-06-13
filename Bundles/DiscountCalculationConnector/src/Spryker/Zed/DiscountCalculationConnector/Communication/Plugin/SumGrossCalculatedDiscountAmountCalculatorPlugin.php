<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\DiscountCalculationConnector\Communication\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Calculation\Dependency\Plugin\CalculatorPluginInterface;
use Spryker\Zed\DiscountCalculationConnector\Business\DiscountCalculationConnectorFacade;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method DiscountCalculationConnectorFacade getFacade()
 */
class SumGrossCalculatedDiscountAmountCalculatorPlugin extends AbstractPlugin implements CalculatorPluginInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    public function recalculate(QuoteTransfer $quoteTransfer)
    {
        $this->getFacade()->calculateSumGrossCalculatedDiscountAmount($quoteTransfer);
    }

}
