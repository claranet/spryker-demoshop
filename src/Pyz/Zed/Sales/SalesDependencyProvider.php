<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Sales;

use Spryker\Zed\Customer\Communication\Plugin\Sales\CustomerOrderHydratePlugin;
use Spryker\Zed\Discount\Communication\Plugin\Sales\DiscountOrderHydratePlugin;
use Spryker\Zed\ManualOrderEntry\Communication\Plugin\Sales\OrderSourceExpanderPreSavePlugin;
use Spryker\Zed\Payment\Communication\Plugin\Sales\PaymentOrderHydratePlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Sales\ProductBundleIdHydratorPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\Sales\ProductBundleOrderHydratePlugin;
use Spryker\Zed\ProductMeasurementUnit\Communication\Plugin\SalesExtension\QuantitySalesUnitOrderItemExpanderPreSavePlugin;
use Spryker\Zed\ProductOption\Communication\Plugin\Sales\ProductOptionGroupIdHydratorPlugin;
use Spryker\Zed\ProductOption\Communication\Plugin\Sales\ProductOptionOrderHydratePlugin;
use Spryker\Zed\ProductOption\Communication\Plugin\Sales\ProductOptionSortHydratePlugin;
use Spryker\Zed\Sales\SalesDependencyProvider as SprykerSalesDependencyProvider;
use Spryker\Zed\SalesProductConnector\Communication\Plugin\Sales\ItemMetadataHydratorPlugin;
use Spryker\Zed\SalesProductConnector\Communication\Plugin\Sales\ProductIdHydratorPlugin;
use Spryker\Zed\SalesReclamation\Communication\Plugin\SalesTablePlugin;
use Spryker\Zed\Shipment\Communication\Plugin\ShipmentOrderHydratePlugin;

class SalesDependencyProvider extends SprykerSalesDependencyProvider
{
    /**
     * @return \Spryker\Zed\Sales\Dependency\Plugin\OrderExpanderPreSavePluginInterface[]
     */
    protected function getOrderExpanderPreSavePlugins()
    {
        return [
            new OrderSourceExpanderPreSavePlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\Sales\Dependency\Plugin\HydrateOrderPluginInterface[]
     */
    protected function getOrderHydrationPlugins()
    {
        return [
            new ProductIdHydratorPlugin(),
            new ProductOptionOrderHydratePlugin(),
            new ProductOptionSortHydratePlugin(),
            new ProductBundleOrderHydratePlugin(),
            new DiscountOrderHydratePlugin(),
            new ShipmentOrderHydratePlugin(),
            new PaymentOrderHydratePlugin(),
            new CustomerOrderHydratePlugin(),
            new ItemMetadataHydratorPlugin(),
            new ProductBundleIdHydratorPlugin(),
            new ProductOptionGroupIdHydratorPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\OrderItemExpanderPreSavePluginInterface[]
     */
    protected function getOrderItemExpanderPreSavePlugins()
    {
        return [
            new QuantitySalesUnitOrderItemExpanderPreSavePlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SalesExtension\Dependency\Plugin\SalesTablePluginInterface[]
     */
    protected function getSalesTablePlugins()
    {
        return [
            new SalesTablePlugin(),
        ];
    }
}
