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

module.exports = {
    loadTime: loadTime
};
