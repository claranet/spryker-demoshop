const webpack = require('webpack');
const rimraf = require('rimraf');
const { globalSettings } = require('../settings');

// execute webpack compiler
// and nicely handle the console output
const compile = (config, storeName) => {
    console.log(`Building for ${config.mode}...`);

    if (config.watch) {
        console.log('Watch mode: ON');
    }

    webpack(config, (err, stats) => {
        if (err) {
            console.error(err.stack || err);

            if (err.details) {
                console.error(err.details);
            }

            return;
        }
        console.log(`${storeName} store building statistics:`);
        console.log(stats.toString(config.stats), '\n');
    });
};

// execute webpack compiler on array of configurations
// and nicely handle the console output
const multiCompile = configs => {
    if (configs.length === 0 || configs.length === undefined) {
        return console.error('No configuration provided. Build aborted.');
    }

    configs.forEach((config) => {
        console.log(`${config.storeName} building for ${config.webpack.mode}...`);

        if (config.webpack.watch) {
            console.log(`${config.storeName} watch mode: ON`);
        }
    });

    const webpackConfigs = configs.map(item => item.webpack);
    webpack(webpackConfigs, (err, multiStats) => {
        if (err) {
            console.error(err.stack || err);

            if (err.details) {
                console.error(err.details);
            }

            return;
        }

        multiStats.stats.forEach(
            (stat, index) => {
                console.log(`${configs[index].storeName} store building statistics:`);
                console.log(`Components entry points: ${configs[index].componentEntryPointsLength}`);
                console.log(`Components styles: ${configs[index].stylesLength}`);
                console.log(stat.toString(webpackConfigs[index].stats), '\n')
            }
        );
    });
};

// clear assets
const clearAllAssets = storeIds => {
    if (storeIds.length === 0) {
        rimraf(globalSettings.paths.publicAssets, () => {
            console.log(`${globalSettings.paths.publicAssets} has been removed. \n`);
        });
    }
};

module.exports = {
    compile,
    multiCompile,
    clearAllAssets
};
