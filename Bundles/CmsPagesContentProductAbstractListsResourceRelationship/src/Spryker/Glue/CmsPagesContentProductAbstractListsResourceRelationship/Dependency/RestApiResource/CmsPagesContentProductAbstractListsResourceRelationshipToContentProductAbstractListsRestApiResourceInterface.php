<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CmsPagesContentProductAbstractListsResourceRelationship\Dependency\RestApiResource;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface CmsPagesContentProductAbstractListsResourceRelationshipToContentProductAbstractListsRestApiResourceInterface
{
    /**
     * @phpstan-return array<string, \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface>
     *
     * @param string[] $contentProductAbstractListKeys
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param string $storeName
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[]
     */
    public function getContentProductAbstractListsByKeys(array $contentProductAbstractListKeys, RestRequestInterface $restRequest, string $storeName): array;
}
