<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Content\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ContentTransfer;
use Generated\Shared\Transfer\LocalizedContentTransfer;
use Orm\Zed\Content\Persistence\SpyContent;
use Propel\Runtime\Collection\Collection;

class ContentMapper implements ContentMapperInterface
{
    /**
     * @param \Orm\Zed\Content\Persistence\SpyContent $contentEntity
     *
     * @return \Generated\Shared\Transfer\ContentTransfer
     */
    public function mapContentEntityToTransfer(SpyContent $contentEntity): ContentTransfer
    {
        $contentTransfer = new ContentTransfer();
        $contentTransfer->fromArray(
            $contentEntity->toArray(),
            true
        );

        foreach ($contentEntity->getSpyContentLocalizeds() as $contentLocalizedEntity) {
            $contentContentTransfer = new LocalizedContentTransfer();
            $contentContentTransfer->fromArray($contentLocalizedEntity->toArray(), true);
            $contentTransfer->addLocalizedContent($contentContentTransfer);
        }

        return $contentTransfer;
    }

    /**
     * @phpstan-return array<int, \Generated\Shared\Transfer\ContentTransfer>
     *
     * @param \Propel\Runtime\Collection\Collection|\Orm\Zed\Content\Persistence\SpyContent[] $contentEntities
     *
     * @return \Generated\Shared\Transfer\ContentTransfer[]
     */
    public function mapContentEntitiesToContentTransfers(Collection $contentEntities): array
    {
        $contentTransfers = [];
        foreach ($contentEntities as $contentEntity) {
            $contentTransfers[] = $this->mapContentEntityToTransfer($contentEntity);
        }

        return $contentTransfers;
    }
}
