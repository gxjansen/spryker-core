<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Application\Plugin\Provider;

use Silex\ControllerProviderInterface as SilexControllerProviderInterface;

/**
 * @deprecated Will be removed without replacement.
 */
interface ControllerProviderInterface extends SilexControllerProviderInterface
{
    /**
     * Returns the url prefix that should be pre pendend to all
     * urls from this provider
     *
     * @return string
     */
    public function getUrlPrefix();
}
