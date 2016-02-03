<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\DiscountCalculationConnector\Dependency\Facade;

use Spryker\Zed\Discount\Business\DiscountFacade;
use Spryker\Zed\Calculation\Business\Model\CalculableInterface;

class DiscountCalculationToDiscountBridge implements DiscountCalculationToDiscountInterface
{

    /**
     * @var \Spryker\Zed\Discount\Business\DiscountFacade
     */
    protected $discountFacade;

    /**
     * @param \Spryker\Zed\Discount\Business\DiscountFacade $discountFacade
     */
    public function __construct($discountFacade)
    {
        $this->discountFacade = $discountFacade;
    }

    /**
     * @param \Spryker\Zed\Calculation\Business\Model\CalculableInterface $calculableContainer
     *
     * @return \Orm\Zed\Discount\Persistence\SpyDiscount[]
     */
    public function calculateDiscounts(CalculableInterface $calculableContainer)
    {
        return $this->discountFacade->calculateDiscounts($calculableContainer);
    }

}
