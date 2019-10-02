<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Carts\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\Carts\CartsApiTester;
use Spryker\Glue\CartsRestApi\CartsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Carts
 * @group RestApi
 * @group CartRestApiCest
 * @group GuestCartsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class GuestCartsRestApiCest
{
    /**
     * @var \PyzTest\Glue\Carts\RestApi\CartsRestApiFixtures
     */
    protected $fixtures;

    /**
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CartsApiTester $I): void
    {
        $this->fixtures = $I->loadFixtures(CartsRestApiFixtures::class);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', '123');

        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->amSure('Returned resource is of type guest-carts')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType('guest-carts');
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateGuestCartWithoutSku(CartsApiTester $I): void
    {
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => 1,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestCreateGuestCartWithoutQuantity(CartsApiTester $I): void
    {
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPOST(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestFindGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendGET(
            $I->formatUrl(
                '{resourceGuestCarts}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                ]
            )
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestFindGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Act
        $I->sendGET(
            $I->formatUrl(
                '{resourceGuestCarts}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                ]
            )
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS3);

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getEmptyGuestQuoteTransfer()->getUuid(),
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'attributes' => [
                        'name' => $I::TEST_GUEST_CART_NAME,
                        'currency' => $I::CURRENCY_EUR,
                        'priceMode' => $I::GROSS_MODE,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdatePriceModeOfNonEmptyGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'attributes' => [
                        'name' => $I::TEST_GUEST_CART_NAME,
                        'currency' => $I::CURRENCY_EUR,
                        'priceMode' => $I::GROSS_MODE,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateGuestCartWithoutGuestCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPATCH(
            CartsRestApiConfig::RESOURCE_GUEST_CARTS,
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'attributes' => [
                        'name' => $I::TEST_GUEST_CART_NAME,
                        'currency' => $I::CURRENCY_EUR,
                        'priceMode' => $I::GROSS_MODE,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'attributes' => [
                        'name' => $I::TEST_GUEST_CART_NAME,
                        'currency' => $I::CURRENCY_EUR,
                        'priceMode' => $I::GROSS_MODE,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->amSure('Returned resource is of type guest-carts')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType('guest-carts');
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer2()->getSku(),
                        'quantity' => 1,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToGuestCartWithoutItemSku(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => 1,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestAddItemsToGuestCartWithoutItemQuantity(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPOST(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'sku' => $this->fixtures->getProductConcreteTransfer2()->getSku(),
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer2()->getSku(),
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => $I::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->amSure('Returned resource is of type guest-carts')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType('guest-carts');

        $I->seeCartItemQuantityEqualsToQuantityInRequest(
            $I::QUANTITY_FOR_ITEM_UPDATE,
            $this->fixtures->getProductConcreteTransfer1()->getSku()
        );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCartWithoutGuestCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}//{resourceGuestCartItems}/{guestCartItemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'guestCartItemSku' => $this->fixtures->getProductConcreteTransfer2()->getSku(),
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => $I::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => $I::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCartWithoutQuantity(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestUpdateItemsInGuestCartWithoutItemSku(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendPATCH(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ]
            ),
            [
                'data' => [
                    'type' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'attributes' => [
                        'quantity' => $I::QUANTITY_FOR_ITEM_UPDATE,
                    ],
                ],
            ]
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromGuestCart(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer2()->getSku(),
                ]
            )
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromGuestCartWithoutGuestCartUuid(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceGuestCarts}//{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                ]
            )
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromGuestCartWithoutAnonymousCustomerUniqueId(CartsApiTester $I): void
    {
        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{itemSku}',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                    'itemSku' => $this->fixtures->getProductConcreteTransfer1()->getSku(),
                ]
            )
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     *
     * @return void
     */
    public function requestDeleteItemsFromGuestCartWithoutItemSku(CartsApiTester $I): void
    {
        // Arrange
        $I->haveHttpHeader('X-Anonymous-Customer-Unique-Id', $I::VALUE_FOR_ANONYMOUS2);

        // Act
        $I->sendDelete(
            $I->formatUrl(
                '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/',
                [
                    'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                    'guestCartUuid' => $this->fixtures->getGuestQuoteTransfer2()->getUuid(),
                    'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                ]
            )
        );

        //assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }
}
