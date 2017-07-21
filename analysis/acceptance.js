var config = require('./config');

/**
 * Shows the load time of the current page.
 * Use it with JS function 'call'
 * 
 * The timing used is based on https://www.w3.org/TR/navigation-timing/#processing-model
 * @param {String} path - URL path that is being tested.
 */
function loadTime(path) {
    this.echo("'" + path + "'" + " load time is: " + this.evaluate(function() {
        var timing = window.performance.timing;
        var start = timing.navigationStart > 0 ? timing.navigationStart : timing.redirectStart;
        return timing.loadEventEnd - start;
    }) + " ms", "INFO_BAR");
}

casper.test.begin('Testing Spryker Demoshop web page', function (test) {
    // Open home page and search for item
    casper.start(config.baseUrl, function () {
        loadTime.call(this, '/');
        test.assertTitle(config.title, 'Home Page title is ' + config.title);
        test.comment('Fill search field');
        this.fill('form[action="/search"]', {
            q: config.item.search
        }, true);
    });

    // Click on requested item
    casper.then(function () {
        test.assertExists('a[href="' + config.item.href + '"]');
        this.click('a[href="' + config.item.href + '"]');
    });

    // Add item to cart
    casper.then(function () {
        test.assertTitle(config.item.title, 'Title is ' + config.item.title);
        test.comment('Add item to cart');
        test.assertSelectorHasText('h5', 'Product Variants');
        this.fill('form[method="GET"]', config.item.variants, false);
    });

    casper.then(function () {
        var btnDisabled = this.evaluate(function (btn) {
            return document.querySelector(btn).hasAttribute('disabled');
        }, 'button.button.expanded.success');
        test.comment('Test if "Add to cart" button is enabled');
        test.assertFalsy(btnDisabled);
        test.assertExists('button.button.expanded.success');
        this.click('button.button.expanded.success');
    });

    // Go to checkout
    casper.then(function () {
        loadTime.call(this, '/cart');
        test.assertSelectorHasText('h3', 'Cart');
        test.comment('Proceed to checkout');
        this.click('a.button.expanded.success');
    });

    // Fill checkout-guest form
    casper.then(function () {
        this.click('input#guest');
        test.assertSelectorHasText('.__checkout-proceed-as-method.__is-shown', ' Order as guest');
        test.comment('Fill user form');
        this.fill('form[name="guestForm"]', config.guest.register, true);
    });

    // Fill address information
    casper.then(function () {
        test.assertSelectorHasText('h3', 'Address');
        test.assertSelectorHasText('h4', 'Shipping Address');
        test.comment('Fill address form');
        this.fill('form[name="addressesForm"]', config.guest.address, true);
    });

    casper.run(function () {
        test.done();
    });
});
