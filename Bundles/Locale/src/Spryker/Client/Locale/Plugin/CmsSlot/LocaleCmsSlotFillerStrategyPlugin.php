<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Locale\Plugin\CmsSlot;

use Spryker\Client\CmsSlotExtension\Dependency\Plugin\CmsSlotFillerStrategyPluginInterface;
use Spryker\Client\Kernel\AbstractPlugin;

/**
 * @method \Spryker\Client\Locale\LocaleClientInterface getClient()
 */
class LocaleCmsSlotFillerStrategyPlugin extends AbstractPlugin implements CmsSlotFillerStrategyPluginInterface
{
    protected const FILLING_KEY = 'locale';

    /**
     * @param string $fillingKey
     *
     * @return bool
     */
    public function isApplicable(string $fillingKey): bool
    {
        return $fillingKey === static::FILLING_KEY;
    }

    /**
     * @param string $fillingKey
     *
     * @return string|mixed
     */
    public function fill(string $fillingKey)
    {
        return $this->getClient()->getCurrentLocale();
    }
}
