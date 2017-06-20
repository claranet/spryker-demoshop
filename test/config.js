module.exports = {
    title: 'Spryker Shop',
    baseUrl: 'http://localhost:2380/',
    item: {
        search: 'dell chromebook 13',
        href: '/en/dell-chromebook-13-63',
        title: 'DELL Chromebook 13',
        variants: {
            'attribute[processor_frequency]': '2 GHz'
        }
    },
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
        }
    }
};