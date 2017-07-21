<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Importer\Business\Importer\ProductSet;

use Generated\Shared\Transfer\LocalizedProductSetTransfer;
use Generated\Shared\Transfer\ProductImageSetTransfer;
use Generated\Shared\Transfer\ProductImageTransfer;
use Generated\Shared\Transfer\ProductSetDataTransfer;
use Generated\Shared\Transfer\ProductSetTransfer;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\ProductSet\Persistence\SpyProductSetQuery;
use Propel\Runtime\Formatter\SimpleArrayFormatter;
use Pyz\Zed\Importer\Business\Importer\AbstractImporter;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;
use Spryker\Zed\ProductSet\Business\ProductSetFacadeInterface;

class ProductSetImporter extends AbstractImporter
{

    /**
     * @var \Spryker\Zed\ProductSet\Business\ProductSetFacadeInterface
     */
    protected $productSetFacade;

    /**
     * @var array|null
     */
    protected static $productAbstractSkuCache;

    /**
     * @var array
     */
    protected $availableLocales;

    /**
     * @param \Spryker\Zed\Locale\Business\LocaleFacadeInterface $localeFacade
     * @param \Spryker\Zed\ProductSet\Business\ProductSetFacadeInterface $productSetFacade
     */
    public function __construct(
        LocaleFacadeInterface $localeFacade,
        ProductSetFacadeInterface $productSetFacade
    ) {
        parent::__construct($localeFacade);

        $this->productSetFacade = $productSetFacade;
    }

    /**
     * @return bool
     */
    public function isImported()
    {
        $query = SpyProductSetQuery::create();

        return $query->count() > 0;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Product Set';
    }

    /**
     * @param array $data
     *
     * @return void
     */
    protected function importOne(array $data)
    {
        if (!$data) {
            return;
        }

        $productSetTransfer = $this->mapGeneralData($data);
        $productSetTransfer = $this->mapLocalizedData($productSetTransfer, $data);
        $productSetTransfer = $this->mapProducts($productSetTransfer, $data);
        $productSetTransfer = $this->mapProductImageSets($productSetTransfer, $data);

        $this->productSetFacade->createProductSet($productSetTransfer);
    }

    /**
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\ProductSetTransfer
     */
    protected function mapGeneralData(array $data)
    {
        $productSetTransfer = new ProductSetTransfer();
        $productSetTransfer
            ->setWeight($data['weight'])
            ->setProductSetKey($data['product_set_key'])
            ->setIsActive((bool)(int)$data['is_active']);

        return $productSetTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetTransfer $productSetTransfer
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\ProductSetTransfer
     */
    protected function mapLocalizedData(ProductSetTransfer $productSetTransfer, array $data)
    {
        foreach ($this->getAvailableLocales() as $localeTransfer) {
            if (!isset($data[sprintf('name.%s', $localeTransfer->getLocaleName())])) {
                continue;
            }

            $productSetDataTransfer = new ProductSetDataTransfer();
            $productSetDataTransfer
                ->setFkLocale($localeTransfer->getIdLocale())
                ->setName($data[sprintf('name.%s', $localeTransfer->getLocaleName())])
                ->setDescription($data[sprintf('description.%s', $localeTransfer->getLocaleName())])
                ->setMetaTitle($data[sprintf('meta_title.%s', $localeTransfer->getLocaleName())])
                ->setMetaKeywords($data[sprintf('meta_keywords.%s', $localeTransfer->getLocaleName())])
                ->setMetaDescription($data[sprintf('meta_description.%s', $localeTransfer->getLocaleName())]);

            $localizedProductSetTransfer = new LocalizedProductSetTransfer();
            $localizedProductSetTransfer
                ->setLocale($localeTransfer)
                ->setUrl($data[sprintf('url.%s', $localeTransfer->getLocaleName())])
                ->setProductSetData($productSetDataTransfer);

            $productSetTransfer->addLocalizedData($localizedProductSetTransfer);
        }

        return $productSetTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetTransfer $productSetTransfer
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\ProductSetTransfer
     */
    protected function mapProducts(ProductSetTransfer $productSetTransfer, array $data)
    {
        $productAbstractSkus = explode(',', $data['abstract_skus']);
        $productAbstractSkus = array_map('trim', $productAbstractSkus);

        foreach ($productAbstractSkus as $productAbstractSku) {
            $idProductAbstract = $this->getIdProductAbstract($productAbstractSku);
            $productSetTransfer->addIdProductAbstract($idProductAbstract);
        }

        return $productSetTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductSetTransfer $productSetTransfer
     * @param array $data
     *
     * @return \Generated\Shared\Transfer\ProductSetTransfer
     */
    protected function mapProductImageSets(ProductSetTransfer $productSetTransfer, array $data)
    {
        $imageSetIndex = 1;
        while (array_key_exists(sprintf('image_set.%s', $imageSetIndex), $data)) {
            $productImageSetTransfer = new ProductImageSetTransfer();
            $productImageSetTransfer->setName($data[sprintf('image_set.%s', $imageSetIndex)]);

            $imageIndex = 1;
            while (array_key_exists(sprintf('image_small.%s.%s', $imageSetIndex, $imageIndex), $data) && array_key_exists(sprintf('image_large.%s.%s', $imageSetIndex, $imageIndex), $data)) {
                $productImageTransfer = new ProductImageTransfer();
                $productImageTransfer
                    ->setExternalUrlSmall($data[sprintf('image_small.%s.%s', $imageSetIndex, $imageIndex)])
                    ->setExternalUrlLarge($data[sprintf('image_large.%s.%s', $imageSetIndex, $imageIndex)]);

                $productImageSetTransfer->addProductImage($productImageTransfer);
                $imageIndex++;
            }

            $productSetTransfer->addImageSet($productImageSetTransfer);
            $imageSetIndex++;
        }

        return $productSetTransfer;
    }

    /**
     * @param string $productAbstractSku
     *
     * @return int
     */
    protected function getIdProductAbstract($productAbstractSku)
    {
        if (!static::$productAbstractSkuCache) {
            $this->warmUpSkuCache();
        }

        return static::$productAbstractSkuCache[$productAbstractSku];
    }

    /**
     * @return void
     */
    protected function warmUpSkuCache()
    {
        $query = SpyProductAbstractQuery::create()
            ->select([
                SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
                SpyProductAbstractTableMap::COL_SKU,
            ])
            ->setFormatter(new SimpleArrayFormatter());

        foreach ($query->find() as $product) {
            static::$productAbstractSkuCache[$product[SpyProductAbstractTableMap::COL_SKU]] = $product[SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT];
        }
    }

    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer[]
     */
    protected function getAvailableLocales()
    {
        if ($this->availableLocales === null) {
            $this->availableLocales = $this->localeFacade->getLocaleCollection();
        }

        return $this->availableLocales;
    }

}
