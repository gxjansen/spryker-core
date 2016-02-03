<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Country\Business;

use Spryker\Zed\Country\Business\Exception\RegionExistsException;
use Spryker\Zed\Country\Persistence\CountryQueryContainerInterface;
use Orm\Zed\Country\Persistence\SpyRegion;

class RegionManager implements RegionManagerInterface
{

    /**
     * @var \Spryker\Zed\Country\Persistence\CountryQueryContainerInterface
     */
    protected $countryQueryContainer;

    /**
     * @param \Spryker\Zed\Country\Persistence\CountryQueryContainerInterface $countryQueryContainer
     */
    public function __construct(
        CountryQueryContainerInterface $countryQueryContainer
    ) {
        $this->countryQueryContainer = $countryQueryContainer;
    }

    /**
     * @param string $isoCode
     * @param int $fkCountry
     * @param string $regionName
     *
     * @return int
     */
    public function createRegion($isoCode, $fkCountry, $regionName)
    {
        $this->checkRegionDoesNotExist($isoCode);

        $region = new SpyRegion();
        $region
            ->setIso2Code($isoCode)
            ->setFkCountry($fkCountry)
            ->setName($regionName);

        $region->save();

        return $region->getIdRegion();
    }

    /**
     * @param string $isoCode
     *
     * @throws \Spryker\Zed\Country\Business\Exception\RegionExistsException
     *
     * @return void
     */
    protected function checkRegionDoesNotExist($isoCode)
    {
        if ($this->hasRegion($isoCode)) {
            throw new RegionExistsException();
        }
    }

    /**
     * @param string $isoCode
     *
     * @return bool
     */
    public function hasRegion($isoCode)
    {
        $query = $this->countryQueryContainer->queryRegionByIsoCode($isoCode);

        return $query->count() > 0;
    }

}
