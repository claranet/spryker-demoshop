<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Product\Controller;

use Generated\Shared\Transfer\StorageProductTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;

/**
 * @method \Spryker\Client\Product\ProductClientInterface getClient()
 * @method \Pyz\Yves\Product\ProductFactory getFactory()
 */
class ProductController extends AbstractController
{

    /**
     * @param \Generated\Shared\Transfer\StorageProductTransfer $storageProductTransfer
     *
     * @return array
     */
    public function detailAction(StorageProductTransfer $storageProductTransfer)
    {
        $categories = $storageProductTransfer->getCategories();

        $productOptionGroupsTransfer = $this
            ->getFactory()
            ->getProductOptionClient()
            ->getProductOptions($storageProductTransfer->getIdProductAbstract(), $this->getLocale());

        $productData = [
            'product' => $storageProductTransfer,
            'productCategories' => $categories,
            'category' => count($categories) ? end($categories) : null,
            'page_keywords' => $storageProductTransfer->getMetaKeywords(),
            'page_description' => $storageProductTransfer->getMetaDescription(),
            'productOptionGroups' => $productOptionGroupsTransfer,
        ];

        return $productData;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->getApplication()['request'];
    }

}
