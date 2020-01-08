<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CompanyUserStorage\Business;

use Generated\Shared\Transfer\FilterTransfer;

interface CompanyUserStorageFacadeInterface
{
    /**
     * Specification:
     *  - Queries all active company users for the given companyUserIds.
     *  - Removes all inactive company users from storage table.
     *  - Publishes active company users.
     *
     * @api
     *
     * @param int[] $companyUserIds
     *
     * @return void
     */
    public function publishByCompanyUserIds(array $companyUserIds): void;

    /**
     * Specification:
     *  - Queries all active company users for the given companyIds.
     *  - Removes all inactive company users from storage table.
     *  - Publishes active company users.
     *
     * @api
     *
     * @param int[] $companyIds
     *
     * @return void
     */
    public function publishByCompanyIds(array $companyIds): void;

    /**
     * Specification:
     *  - Finds and removes company user storage entities for the given companyUserIds;
     *
     * @api
     *
     * @param int[] $companyUserIds
     *
     * @return void
     */
    public function unpublishByCompanyUserIds(array $companyUserIds): void;

    /**
     * Specification:
     * - Queries company user storage entities for the given companyUserIds filtered by provided FilterTransfer.
     * - Returns a collection of synchronization data transfers mapped from received storage entities.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\FilterTransfer $filterTransfer
     * @param int[] $companyUserIds
     *
     * @return \Generated\Shared\Transfer\CompanyUserStorageTransfer[]
     */
    public function getSynchronizationDataTransferCollectionByFilterAndCompanyUserIds(FilterTransfer $filterTransfer, array $companyUserIds): array;
}
