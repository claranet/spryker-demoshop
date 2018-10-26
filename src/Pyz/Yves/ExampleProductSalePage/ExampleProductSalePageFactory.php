<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ExampleProductSalePage;

use Spryker\Yves\Kernel\AbstractFactory;

class ExampleProductSalePageFactory extends AbstractFactory
{
    /**
     * @return string[]
     */
    public function getExampleProductSalePageWidgetPlugins(): array
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PLUGIN_PRODUCT_SALE_PAGE_WIDGETS);
    }

    /**
     * @return \Spryker\Client\Search\SearchClientInterface
     */
    protected function getSearchClient()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::CLIENT_SEARCH);
    }

    /**
     * @return \Spryker\Client\UrlStorage\UrlStorageClientInterface
     */
    public function getUrlStorageClient()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::CLIENT_URL_STORAGE);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::STORE);
    }

    /**
     * @return \Spryker\Client\Catalog\CatalogClientInterface
     */
    public function getCatalogClient()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::CLIENT_CATALOG);
    }
}
