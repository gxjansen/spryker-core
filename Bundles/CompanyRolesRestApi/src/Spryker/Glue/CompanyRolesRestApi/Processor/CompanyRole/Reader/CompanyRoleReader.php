<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompanyRolesRestApi\Processor\CompanyRole\Reader;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\RestCompanyRoleAttributesTransfer;
use Spryker\Glue\CompanyRolesRestApi\CompanyRolesRestApiConfig;
use Spryker\Glue\CompanyRolesRestApi\Dependency\Client\CompanyRolesRestApiToCompanyRoleClientInterface;
use Spryker\Glue\CompanyRolesRestApi\Processor\CompanyRole\Mapper\CompanyRoleMapperInterface;
use Spryker\Glue\CompanyRolesRestApi\Processor\CompanyRole\RestResponseBuilder\CompanyRoleRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CompanyRoleReader implements CompanyRoleReaderInterface
{
    /**
     * @var \Spryker\Glue\CompanyRolesRestApi\Dependency\Client\CompanyRolesRestApiToCompanyRoleClientInterface
     */
    protected $companyRoleClient;

    /**
     * @var \Spryker\Glue\CompanyRolesRestApi\Processor\CompanyRole\Mapper\CompanyRoleMapperInterface
     */
    protected $companyRoleMapperInterface;

    /**
     * @var \Spryker\Glue\CompanyRolesRestApi\Processor\CompanyRole\RestResponseBuilder\CompanyRoleRestResponseBuilderInterface
     */
    protected $companyRoleRestResponseBuilder;

    /**
     * @param \Spryker\Glue\CompanyRolesRestApi\Dependency\Client\CompanyRolesRestApiToCompanyRoleClientInterface $companyRoleClient
     * @param \Spryker\Glue\CompanyRolesRestApi\Processor\CompanyRole\Mapper\CompanyRoleMapperInterface $companyRoleMapperInterface
     * @param \Spryker\Glue\CompanyRolesRestApi\Processor\CompanyRole\RestResponseBuilder\CompanyRoleRestResponseBuilderInterface $companyRoleRestResponseBuilder
     */
    public function __construct(
        CompanyRolesRestApiToCompanyRoleClientInterface $companyRoleClient,
        CompanyRoleMapperInterface $companyRoleMapperInterface,
        CompanyRoleRestResponseBuilderInterface $companyRoleRestResponseBuilder
    ) {
        $this->companyRoleClient = $companyRoleClient;
        $this->companyRoleMapperInterface = $companyRoleMapperInterface;
        $this->companyRoleRestResponseBuilder = $companyRoleRestResponseBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getCurrentUserCompanyRoles(RestRequestInterface $restRequest): RestResponseInterface
    {
        if (!$restRequest->getRestUser()->getIdCompany()) {
            return $this->companyRoleRestResponseBuilder->createCompanyRoleIdMissingError();
        }

        if (!$this->isCurrentUserResourceIdentifier($restRequest->getResource()->getId())) {
            return $this->companyRoleRestResponseBuilder->createCompanyRoleIdMissingError();
        }

        $companyRoleCollectionTransfer = $this->companyRoleClient->getCompanyRoleCollection(
            (new CompanyRoleCriteriaFilterTransfer())->setIdCompany($restRequest->getRestUser()->getIdCompany())
        );

        if (!$companyRoleCollectionTransfer->getRoles()->count()) {
            return $this->companyRoleRestResponseBuilder->createCompanyRoleNotFoundError();
        }

        return $this->createResponse($companyRoleCollectionTransfer);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getCompanyRole(RestRequestInterface $restRequest): RestResponseInterface
    {
        $companyRoleUuid = $restRequest->getResource()->getId();
        if (!$companyRoleUuid) {
            return $this->companyRoleRestResponseBuilder->createCompanyRoleIdMissingError();
        }

        $companyRoleResponseTransfer = $this->companyRoleClient->findCompanyRoleByUuid(
            (new CompanyRoleTransfer())->setUuid($companyRoleUuid)
        );

        if (!$companyRoleResponseTransfer->getIsSuccessful()
            || !$this->isCurrentCompanyUserAuthorizedToAccessCompanyRoleResource($restRequest, $companyRoleResponseTransfer->getCompanyRoleTransfer())
        ) {
            return $this->companyRoleRestResponseBuilder->createCompanyRoleNotFoundError();
        }

        $restCompanyRoleAttributesTransfer = $this->companyRoleMapperInterface
            ->mapCompanyRoleTransferToRestCompanyRoleAttributesTransfer(
                $companyRoleResponseTransfer->getCompanyRoleTransfer(),
                new RestCompanyRoleAttributesTransfer()
            );

        return $this->companyRoleRestResponseBuilder
            ->createCompanyRoleRestResponse(
                $companyRoleUuid,
                $restCompanyRoleAttributesTransfer,
                $companyRoleResponseTransfer->getCompanyRoleTransfer()
            );
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return bool
     */
    protected function isCurrentCompanyUserAuthorizedToAccessCompanyRoleResource(
        RestRequestInterface $restRequest,
        CompanyRoleTransfer $companyRoleTransfer
    ): bool {
        return $restRequest->getRestUser()
            && $restRequest->getRestUser()->getIdCompany()
            && $restRequest->getRestUser()->getIdCompany() === $companyRoleTransfer->getFkCompany();
    }

    /**
     * @param string $companyRoleIdentifier
     *
     * @return bool
     */
    protected function isCurrentUserResourceIdentifier(string $companyRoleIdentifier): bool
    {
        return $companyRoleIdentifier === CompanyRolesRestApiConfig::CURRENT_USER_RESOURCE_IDENTIFIER;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function createResponse(CompanyRoleCollectionTransfer $companyRoleCollectionTransfer): RestResponseInterface
    {
        $companyRoleRestResponse = $this->companyRoleRestResponseBuilder
            ->createEmptyCompanyRoleRestResponse();

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            $restCompanyRoleAttributesTransfer = $this->companyRoleMapperInterface
                ->mapCompanyRoleTransferToRestCompanyRoleAttributesTransfer(
                    $companyRoleTransfer,
                    new RestCompanyRoleAttributesTransfer()
                );

            $companyRoleRestResponse->addResource(
                $this->companyRoleRestResponseBuilder->createCompanyRoleRestResource(
                    $companyRoleTransfer->getUuid(),
                    $restCompanyRoleAttributesTransfer,
                    $companyRoleTransfer
                )
            );
        }

        return $companyRoleRestResponse;
    }
}
