<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\RestCartItemCalculationsTransfer;
use Generated\Shared\Transfer\RestItemsAttributesTransfer;

class CartItemMapper implements CartItemMapperInterface
{
    /**
     * @var \Spryker\Glue\CartsRestApiExtension\Dependency\Plugin\RestCartItemsAttributesMapperPluginInterface[]
     */
    protected $restCartItemsAttributesMapperPlugins;

    /**
     * @param \Spryker\Glue\CartsRestApiExtension\Dependency\Plugin\RestCartItemsAttributesMapperPluginInterface[] $restCartItemsAttributesMapperPlugins
     */
    public function __construct(array $restCartItemsAttributesMapperPlugins)
    {
        $this->restCartItemsAttributesMapperPlugins = $restCartItemsAttributesMapperPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\RestItemsAttributesTransfer $restItemsAttributesTransfer
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\RestItemsAttributesTransfer
     */
    public function mapItemTransferToRestItemsAttributesTransfer(
        ItemTransfer $itemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer,
        string $localeName
    ): RestItemsAttributesTransfer {
        $itemData = $itemTransfer->toArray();

        $restItemsAttributesTransfer->fromArray($itemData, true);

        $restCartItemCalculationsTransfer = $restItemsAttributesTransfer->getCalculations();
        if (!$restCartItemCalculationsTransfer) {
            $restCartItemCalculationsTransfer = new RestCartItemCalculationsTransfer();
        }
        $restItemsAttributesTransfer->setCalculations($restCartItemCalculationsTransfer->fromArray($itemData, true));

        return $this->expandRestItemsAttributesTransfer(
            $itemTransfer,
            $restItemsAttributesTransfer,
            $localeName
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\RestItemsAttributesTransfer $restItemsAttributesTransfer
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\RestItemsAttributesTransfer
     */
    protected function expandRestItemsAttributesTransfer(
        ItemTransfer $itemTransfer,
        RestItemsAttributesTransfer $restItemsAttributesTransfer,
        string $localeName
    ): RestItemsAttributesTransfer {
        foreach ($this->restCartItemsAttributesMapperPlugins as $restOrderItemsAttributesMapperPlugin) {
            $restItemsAttributesTransfer =
                $restOrderItemsAttributesMapperPlugin->mapItemTransferToRestItemsAttributesTransfer(
                    $itemTransfer,
                    $restItemsAttributesTransfer,
                    $localeName
                );
        }

        return $restItemsAttributesTransfer;
    }
}
