<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductCategoryStorage\Business;

use Generated\Shared\Transfer\FilterTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\ProductCategoryStorage\Business\ProductCategoryStorageBusinessFactory getFactory()
 * @method \Spryker\Zed\ProductCategoryStorage\Persistence\ProductCategoryStorageRepositoryInterface getRepository()
 * @method \Spryker\Zed\ProductCategoryStorage\Persistence\ProductCategoryStorageEntityManagerInterface getEntityManager()
 */
class ProductCategoryStorageFacade extends AbstractFacade implements ProductCategoryStorageFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @deprecated This will be deleted in the next major without replacement.
     *
     * @param int[] $productAbstractIds
     *
     * @return void
     */
    public function publish(array $productAbstractIds)
    {
        $this->getFactory()->createProductCategoryStorageWriter()->writeCollection($productAbstractIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @deprecated This will be deleted in the next major without replacement.
     *
     * @param int[] $productAbstractIds
     *
     * @return void
     */
    public function unpublish(array $productAbstractIds)
    {
        $this->getFactory()->createProductCategoryStorageDeleter()->deleteCollection($productAbstractIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int[] $categoryIds
     *
     * @return int[]
     */
    public function getRelatedCategoryIds(array $categoryIds)
    {
        return $this->getFactory()->createProductAbstractReader()->getRelatedCategoryIds($categoryIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByCategoryStoreEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByCategoryStoreEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByCategoryStorePublishingEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByCategoryStorePublishingEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function deleteCollectionByCategoryStoreEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageDeleter()
            ->deleteCollectionByCategoryStoreEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByCategoryAttributeEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByCategoryAttributeEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByCategoryAttributeNameEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByCategoryAttributeNameEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByCategoryNodeEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByCategoryNodeEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByCategoryEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByCategoryEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByCategoryIsActiveAndCategoryKeyEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByCategoryIsActiveAndCategoryKeyEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByCategoryUrlEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByCategoryUrlEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByCategoryUrlAndResourceCategorynodeEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByCategoryUrlAndResourceCategorynodeEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByProductCategoryPublishingEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByProductCategoryPublishingEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventEntityTransfers
     *
     * @return void
     */
    public function writeCollectionByProductCategoryEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createProductCategoryStorageWriter()
            ->writeCollectionByProductCategoryEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $offset
     * @param int $limit
     * @param int[] $productAbstractIds
     *
     * @return \Generated\Shared\Transfer\SynchronizationDataTransfer[]
     */
    public function findProductAbstractCategoryStorageSynchronizationDataTransfersByProductAbstractIds(
        int $offset,
        int $limit,
        array $productAbstractIds
    ): array {
        return $this->getRepository()
            ->findProductAbstractCategoryStorageSynchronizationDataTransfersByProductAbstractIds($offset, $limit, $productAbstractIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     *
     * @return \Generated\Shared\Transfer\ProductCategoryTransfer[]
     */
    public function findProductCategoryTransfersByFilter(FilterTransfer $filterTransfer): array
    {
        return $this->getRepository()
            ->findProductCategoryTransfersByFilter($filterTransfer);
    }
}
