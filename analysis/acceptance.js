const config = require('./config');

var totalTime = 1;

/**
 * Shows the load time of the current page.
 * Use it with JS function 'call'
 * 
 * The timing used is based on https://www.w3.org/TR/navigation-timing/#processing-model
 * @param {String} path - URL path that is being tested.
 */
function loadTime(path) {    
    this.echo("'" + path + "'" + " load time is: " + this.evaluate(function () {
        var timing = window.performance.timing;
        var start = timing.navigationStart > 0 ? timing.navigationStart : timing.redirectStart;
        var localTotal = timing.loadEventEnd - start;
        
        return localTotal;
    }) + " ms", "INFO");
}

casper.test.begin('Testing Spryker Demoshop web page', function (test) {
    // Open home page and search for item
    casper.start(config.baseUrl, function () {
        loadTime.call(this, this.getCurrentUrl());
        this.echo(totalTime);
        test.assertTitle(config.title, 'Home Page title is ' + config.title);
        
        test.comment('Fill search field');
        this.fill('form[action="/search"]', {
            q: config.item.search
        }, true);
    });

    // Search preview box
    // Click on requested item
    casper.then(function () {
        test.assertExists('a[href="' + config.item.href + '"]');
        this.click('a[href="' + config.item.href + '"]');
    });

    // Item view
    // Add item to cart
    casper.then(function () {
        test.comment('Add item to cart');
        loadTime.call(this, this.getCurrentUrl());
        test.assertTitle(config.item.title, 'Title is ' + config.item.title);
        test.assertSelectorHasText('h5', 'Product Variants');
        this.fill('form[method="GET"]', config.item.variants, false);
    });

    casper.then(function () {
        test.comment('Test if "Add to cart" button is enabled');
        var btnDisabled = this.evaluate(function (btn) {
            return document.querySelector(btn).hasAttribute('disabled');
        }, 'button.button.expanded.success');
        test.assertFalsy(btnDisabled);
        test.assertExists('button.button.expanded.success');
        this.click('button.button.expanded.success');
    });

    // Cart view
    // Go to checkout
    casper.then(function () {
        test.comment('Proceed to checkout');
        loadTime.call(this, this.getCurrentUrl());
        test.assertSelectorHasText('h3', 'Cart');
        this.click('a.button.expanded.success');
    });

    // Cart - Login
    // Fill checkout-guest form
    casper.then(function () {
        test.comment('Fill user form');
        loadTime.call(this, this.getCurrentUrl());
        this.click('input#guest');
        test.assertSelectorHasText('.__checkout-proceed-as-method.__is-shown', ' Order as guest');
        this.fill('form[name="guestForm"]', config.guest.register, true);
    });

    // Cart - Address
    // Fill address information
    casper.then(function () {
        test.comment('Fill address form');
        loadTime.call(this, this.getCurrentUrl());
        test.assertSelectorHasText('h3', 'Address');
        test.assertSelectorHasText('h4', 'Shipping Address');
        this.fill('form[name="addressesForm"]', config.guest.address, true);
    });

    // Cart - Shipment
    // Choose shipping method
    casper.then(function () {
        test.comment('Choose shipping method');
        loadTime.call(this, this.getCurrentUrl());
        test.assertSelectorHasText('h3', 'Shipment');
        this.fill('form[name="shipmentForm"]', config.guest.shipment, true);
    });

    // Cart - Payment
    // Choose payment method
    casper.then(function () {
        test.comment('Choose payment method');
        loadTime.call(this, this.getCurrentUrl());
        test.assertSelectorHasText('h3', 'Payment');
        this.fill('form[name="paymentForm"]', config.guest.payment, true);
    });

    // Cart - Summary
    casper.then(function () {
        test.comment('Submit order');
        loadTime.call(this, this.getCurrentUrl());
        test.assertSelectorHasText('h3', 'Summary');
        this.fill('form[name="summaryForm"]', {}, true);
    });

    casper.run(function () {
        test.done();
    });
});