<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Url;

use Spryker\Zed\Navigation\Communication\Plugin\DetachNavigationUrlAfterUrlDeletePlugin;
use Spryker\Zed\Url\UrlDependencyProvider as SprykerUrlDependencyProvider;

class UrlDependencyProvider extends SprykerUrlDependencyProvider
{
    /**
     * @return \Spryker\Zed\Url\Dependency\Plugin\UrlUpdatePluginInterface[]
     */
    protected function getUrlBeforeDeletePlugins()
    {
        return [
            new DetachNavigationUrlAfterUrlDeletePlugin(),
        ];
    }
}
