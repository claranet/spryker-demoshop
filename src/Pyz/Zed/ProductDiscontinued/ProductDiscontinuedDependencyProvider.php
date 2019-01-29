<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductDiscontinued;

use Spryker\Zed\ProductDiscontinued\ProductDiscontinuedDependencyProvider as SprykerProductDiscontinuedDependencyProvider;
use Spryker\Zed\ProductDiscontinuedProductBundleConnector\Communication\Plugin\DiscontinueBundlePostProductDiscontinuePlugin;
use Spryker\Zed\ProductDiscontinuedProductBundleConnector\Communication\Plugin\PreUnmarkProductDiscontinuedBundledProductsPlugin;
use Spryker\Zed\ProductDiscontinuedProductLabelConnector\Communication\Plugin\PostDeleteProductDiscontinuedPlugin;
use Spryker\Zed\ProductDiscontinuedProductLabelConnector\Communication\Plugin\PostProductDiscontinuedPlugin;

class ProductDiscontinuedDependencyProvider extends SprykerProductDiscontinuedDependencyProvider
{
    /**
     * @return \Spryker\Zed\ProductDiscontinuedExtension\Dependency\Plugin\PostProductDiscontinuePluginInterface[]
     */
    protected function getPostProductDiscontinuePlugins(): array
    {
        return [
            new DiscontinueBundlePostProductDiscontinuePlugin(),
            new PostProductDiscontinuedPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ProductDiscontinuedExtension\Dependency\Plugin\PostDeleteProductDiscontinuedPluginInterface[]
     */
    protected function getPostDeleteProductDiscontinuedPlugins(): array
    {
        return [
            new PostDeleteProductDiscontinuedPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ProductDiscontinuedExtension\Dependency\Plugin\PreUnmarkProductDiscontinuedPluginInterface[]
     */
    protected function getPreUnmarkProductDiscontinuedPlugins(): array
    {
        return [
            new PreUnmarkProductDiscontinuedBundledProductsPlugin(),
        ];
    }
}
