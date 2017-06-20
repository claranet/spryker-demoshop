const BASE_URL = 'http://localhost:2380/';

casper.test.begin('Testing Spryker Demoshop web page', function (test) {
    // Open home page and search for item
    casper.start(BASE_URL, function () {
        test.assertTitle('Spryker Shop', 'Home Page title is Spryker Shop');
        test.comment('Fill search field');
        this.fill('form[action="/search"]', {
            q: 'dell chromebook 13'
        }, true);
    });

    // Click on requested item
    casper.then(function () {
        test.assertExists('a[href="/en/dell-chromebook-13-63"]');
        this.click('a[href="/en/dell-chromebook-13-63"]');
    });

    // Add item to cart
    casper.then(function () {
        test.assertTitle('DELL Chromebook 13', 'Title is DELL Chromebook 13');
        test.comment('Add item to cart');
        test.assertSelectorHasText('h5', 'Product Variants');
        this.fill('form[method="GET"]', {
            'attribute[processor_frequency]': '2 GHz'
        }, false);
    });

    casper.then(function () {
        const btnDisabled = this.evaluate(function (btn) {
            return document.querySelector(btn).hasAttribute('disabled');
        }, 'button.button.expanded.success');
        test.assertFalsy(btnDisabled);
        test.assertExists('button.button.expanded.success');
        this.click('button.button.expanded.success');
    });

    // Go to checkout
    casper.then(function () {
        test.assertSelectorHasText('h3', 'Cart');
        test.comment('Proceed to checkout');
        // this.click('a.button.expanded.success');     // Uncomment when links are working
        casper.open(BASE_URL + 'checkout');     // This should be taken out when the links are working properly
    });

    // Fill checkout-guest form
    casper.then(function () {
        this.click('input#guest');
        test.assertSelectorHasText('.__checkout-proceed-as-method.__is-shown', ' Order as guest');
        test.comment('Fill user form');
        this.fill('form.callout', {
            'guestForm[customer][salutation]': 'Mr.',
            'guestForm[customer][first_name]': 'John',
            'guestForm[customer][last_name]': 'Doe',
            'guestForm[customer][email]': 'john@doe.com',
            'guestForm[customer][accept_terms]': true
        }, true);
    });

    // Fill address information
    casper.then(function () {
        test.assertSelectorHasText('h3', 'Address');
        test.assertSelectorHasText('h4', 'Shipping Address');
        test.comment('Fill address form');
        this.fill('form[name=addressesForm]', {
            'addressesForm[shippingAddress][salutation]': 'Mr.',
            'addressesForm[shippingAddress][first_name]': 'John',
            'addressesForm[shippingAddress][last_name]': 'Doe',
            'addressesForm[shippingAddress][address1]': 'That Street',
            'addressesForm[shippingAddress][address2]': '1',
            'addressesForm[shippingAddress][zip_code]': '12345',
            'addressesForm[shippingAddress][city]': 'City',
            'addressesForm[billingSameAsShipping]': true
        }, true);
    });

    casper.run(function () {
        test.done();
    });
});