<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\QuickOrderPage;

use SprykerShop\Yves\MultiCartWidget\Plugin\QuickOrderPage\MultiCartListWidgetPlugin;
use SprykerShop\Yves\QuickOrderPage\QuickOrderPageDependencyProvider as SprykerQuickOrderPageDependencyProvider;

class QuickOrderPageDependencyProvider extends SprykerQuickOrderPageDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getQuickOrderPageWidgetPlugins(): array
    {
        return [
            MultiCartListWidgetPlugin::class, #MultiCartFeature
        ];
    }
}
