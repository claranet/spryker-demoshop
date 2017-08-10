/**
 * Default config for testing transaction time on demoshop.
 * 
 */
module.exports = {
    //Set critical and warning times
    critical: 0,
    warning: 0,

    title: 'Spryker Shop',
    baseUrl: 'http://localhost:2380/',
    search: {
        fieldSelector: 'input[name=q]',
        item: 'dell chromebook 13',
        
        // Text in the elasticSearch results box
        waitForText: 'Search suggestions'
    },
    item: {
        href: '/en/dell-chromebook-13-63',
        title: 'DELL Chromebook 13',
        variantsText: 'Product Variants',
        variants: {
            'attribute[processor_frequency]': '2 GHz'
        }
    },
    selectorCart: 'Cart',
    selectorGuest: ' Order as guest',
    selectorAddress: 'Address',
    selectorShippingAddress: 'Shipping Address',
    selectorShipment: 'Shipment',
    selectorPayment: 'Payment',
    selectorSummary: 'Summary',
    guest: {
        register: {
            'guestForm[customer][salutation]': 'Mr.',
            'guestForm[customer][first_name]': 'John',
            'guestForm[customer][last_name]': 'Doe',
            'guestForm[customer][email]': 'john@doe.com',
            'guestForm[customer][accept_terms]': true
        },
        address: {
            'addressesForm[shippingAddress][salutation]': 'Mr.',
            'addressesForm[shippingAddress][first_name]': 'John',
            'addressesForm[shippingAddress][last_name]': 'Doe',
            'addressesForm[shippingAddress][address1]': 'That Street',
            'addressesForm[shippingAddress][address2]': '1',
            'addressesForm[shippingAddress][zip_code]': '12345',
            'addressesForm[shippingAddress][city]': 'City',
            'addressesForm[billingSameAsShipping]': true
        },
        shipment: {
            'shipmentForm[idShipmentMethod]': '2'
        },
        payment: {
            'paymentForm[paymentSelection]': 'dummyPaymentInvoice',
            'paymentForm[dummyPaymentInvoice][date_of_birth]': '11.11.11'
        }
    }
};
