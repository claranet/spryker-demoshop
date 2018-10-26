<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\User;

use Spryker\Zed\Acl\Communication\Plugin\GroupPlugin;
use Spryker\Zed\CustomerUserConnectorGui\Communication\Plugin\UsersTableExpanderPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\User\UserDependencyProvider as SprykerUserDependencyProvider;

class UserDependencyProvider extends SprykerUserDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addGroupPlugin(Container $container)
    {
        $container[static::PLUGIN_GROUP] = function (Container $container) {
            return new GroupPlugin();
        };

        return $container;
    }

    /**
     * @return \Spryker\Zed\User\Dependency\Plugin\UsersTableExpanderPluginInterface[]
     */
    protected function getUsersTableExtenderPlugins()
    {
        return [
            new UsersTableExpanderPlugin(),
        ];
    }
}
