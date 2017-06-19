const BASE_URL = 'http://localhost:2380/';

casper.test.begin('Testing Spryker Demoshop web page', function (test) {
    casper.start(BASE_URL, function () {
        test.assertTitle('Spryker Shop', 'Home Page title is Spryker Shop');
        test.assertExists('a[href="/en/canon-powershot-n-40"]');
    });

    casper.then(function () {
        test.comment('Click on first camera item');
        this.click('a[href="/en/canon-powershot-n-40"]');
    });

    casper.then(function () {
        test.assertTitle('Canon PowerShot N', 'Title is Canon PowerShot N');
        test.comment('Add item to cart');
        test.assertExists('button.button.expanded.success');
        this.click('button.button.expanded.success');
    });

    casper.then(function () {
        test.assertSelectorHasText('h3', 'Cart');
        test.comment('Proceed to checkout');
        // this.click('a.button.expanded.success');
        casper.open(BASE_URL + 'checkout');
    });

    casper.then(function () {
        this.click('input#guest');
        test.assertSelectorHasText('.__checkout-proceed-as-method.__is-shown', ' Order as guest');
        this.fill('form.callout', {
            'guestForm[customer][salutation]': 'Mr.',
            'guestForm[customer][first_name]': 'John',
            'guestForm[customer][last_name]': 'Doe',
            'guestForm[customer][email]': 'john@doe.com',
            'guestForm[customer][accept_terms]': true
        }, true);
    });

    casper.run(function () {
        test.done();
    });
});