<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CompaniesRestApi;

use Spryker\Glue\CompaniesRestApi\Processor\Company\Mapper\CompanyMapper;
use Spryker\Glue\CompaniesRestApi\Processor\Company\Mapper\CompanyMapperInterface;
use Spryker\Glue\CompaniesRestApi\Processor\Company\Relationship\CompanyResourceRelationshipExpander;
use Spryker\Glue\CompaniesRestApi\Processor\Company\Relationship\CompanyResourceRelationshipExpanderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CompaniesRestApiFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Glue\CompaniesRestApi\Processor\Company\Mapper\CompanyMapperInterface
     */
    public function createCompanyMapper(): CompanyMapperInterface
    {
        return new CompanyMapper();
    }

    /**
     * @return \Spryker\Glue\CompaniesRestApi\Processor\Company\Relationship\CompanyResourceRelationshipExpanderInterface
     */
    public function createCompanyResourceRelationshipExpander(): CompanyResourceRelationshipExpanderInterface
    {
        return new CompanyResourceRelationshipExpander($this->getResourceBuilder(), $this->createCompanyMapper());
    }
}