/**
 * Shows the load time of the current page.
 * Use it with JS function 'call'
 * 
 * The timing used is based on https://www.w3.org/TR/navigation-timing/#processing-model
 * @param {String} path - URL path that is being tested.
 */
function loadTime(path) {
    var loadingTime = this.evaluate(function () {
        var timing = window.performance.timing;
        var start = timing.navigationStart > 0 ? timing.navigationStart : timing.redirectStart;
        var localTotal = timing.loadEventEnd - start;

        return localTotal;
    });

    this.echo('\'' + path + '\'' + ' load time is: ' + loadingTime + ' ms', 'INFO');

    totalTime += loadingTime;
}

var totalTime = 0;

/**
 * Checks if total time elapsed meets the given criteria.
 * 
 * @param {Number} warning - Warning level in ms.
 * @param {Number} critical - Critical level in ms.
 */
function evalTotalTime(warning, critical) {
    if (warning == 0 && critical == 0) {
        return;
    }

    if (totalTime > critical) {
        this.echo('CRITICAL! Transaction time: ' + totalTime + ' ms', 'RED_BAR');
        this.exit(2);
    } else if (totalTime > warning) {
        this.echo('WARNING! Transaction time: ' + totalTime + ' ms', 'WARN_BAR');
        this.exit(1);
    } else {
        this.echo('OK! Transaction time: ' + totalTime + ' ms', 'GREEN_BAR');
    }
}

module.exports = {
    loadTime: loadTime,
    evalTotalTime: evalTotalTime
};
