<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Refund\Communication\Controller;

use Spryker\Zed\Application\Communication\Controller\AbstractController;
use Spryker\Zed\Refund\Business\RefundFacade;
use Spryker\Zed\Refund\Communication\RefundCommunicationFactory;
use Spryker\Zed\Refund\Persistence\RefundQueryContainer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method RefundCommunicationFactory getFactory()
 * @method RefundFacade getFacade()
 * @method RefundQueryContainer getQueryContainer()
 */
class DetailsController extends AbstractController
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $idRefund = $request->get('id-refund');

        $refundEntity = $this->getQueryContainer()
            ->queryRefundByIdRefund($idRefund)
            ->findOne();

        if ($refundEntity === null) {
            throw new NotFoundHttpException('Record not found');
        }

        $orderItems = $this->getFactory()->getSalesQueryContainer()
            ->querySalesOrderItem()
            ->filterByFkRefund($idRefund)
            ->find();

        $expenses = $this->getFactory()->getSalesQueryContainer()
            ->querySalesExpense()
            ->filterByFkRefund($idRefund)
            ->find();

        return [
            'idRefund' => $idRefund,
            'refund' => $refundEntity,
            'orderItems' => $orderItems,
            'expenses' => $expenses,
        ];
    }

}
