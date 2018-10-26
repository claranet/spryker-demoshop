<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductLabel\Dependency\Plugin\ProductLabelRelationUpdaterPluginInterface;

/**
 * @method \Pyz\Zed\ExampleProductSalePage\Business\ExampleProductSalePageFacadeInterface getFacade()
 */
class ExampleProductSalePageLabelUpdaterPlugin extends AbstractPlugin implements ProductLabelRelationUpdaterPluginInterface
{
    /**
     * @return \Generated\Shared\Transfer\ProductLabelProductAbstractRelationsTransfer[]
     */
    public function findProductLabelProductAbstractRelationChanges()
    {
        return $this->getFacade()->findProductLabelProductAbstractRelationChanges();
    }
}
