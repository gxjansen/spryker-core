<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductsRestApi;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractRestResource;

/**
 * @method \Spryker\Glue\ProductsRestApi\ProductsRestApiFactory getFactory()
 */
class ProductsRestApiResource extends AbstractRestResource implements ProductsRestApiResourceInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $sku
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface|null
     */
    public function findProductAbstractBySku(string $sku, RestRequestInterface $restRequest): ?RestResourceInterface
    {
        return $this->getFactory()
            ->createAbstractProductsReader()
            ->findProductAbstractBySku($sku, $restRequest);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string[] $skus
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[]
     */
    public function getProductAbstractsBySkus(array $skus, RestRequestInterface $restRequest): array
    {
        return $this->getFactory()
            ->createAbstractProductsReader()
            ->getProductAbstractsBySkus($skus, $restRequest);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $sku
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface|null
     */
    public function findProductConcreteBySku(string $sku, RestRequestInterface $restRequest): ?RestResourceInterface
    {
        return $this
            ->getFactory()
            ->createConcreteProductsReader()
            ->findProductConcreteBySku($sku, $restRequest);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface|null
     */
    public function findProductAbstractById(int $idProductAbstract, RestRequestInterface $restRequest): ?RestResourceInterface
    {
        return $this->getFactory()
            ->createAbstractProductsReader()
            ->findProductAbstractById($idProductAbstract, $restRequest);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductConcrete
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface|null
     */
    public function findProductConcreteById(int $idProductConcrete, RestRequestInterface $restRequest): ?RestResourceInterface
    {
        return $this->getFactory()
            ->createConcreteProductsReader()
            ->findProductConcreteById($idProductConcrete, $restRequest);
    }

    /**
     * Specification:
     * - Retrieves multiple abstract product resource by ids.
     * - Returned collection of rest resources is indexed by product abstract id.
     *
     * @api
     *
     * @param int[] $ids
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param string $storeName
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[]
     */
    public function getProductAbstractsByIds(array $ids, RestRequestInterface $restRequest, string $storeName): array
    {
        return $this->getFactory()
            ->createAbstractProductsReader()
            ->getProductAbstractsByIds($ids, $restRequest, $storeName);
    }
}
