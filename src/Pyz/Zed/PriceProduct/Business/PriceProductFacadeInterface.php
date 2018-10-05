<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProduct\Business;

use Spryker\Zed\PriceProduct\Business\PriceProductFacadeInterface as SprykerPriceProductFacadeInterface;
use Spryker\Zed\PriceProductDataImport\Dependency\Facade\PriceProductDataImportToPriceProductFacadeInterface;

interface PriceProductFacadeInterface extends PriceProductDataImportToPriceProductFacadeInterface, SprykerPriceProductFacadeInterface
{
}
