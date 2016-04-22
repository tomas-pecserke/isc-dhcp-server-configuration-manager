<?php
/*
 * This file is part of the isc-dhcp-server-configuration-manager package.
 *
 * (c) Tomas Pecserke <tomas@pecserke.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pecserke\Bundle\IcsDhcpServerManagementBundle;

use Pecserke\Bundle\IcsDhcpServerManagementBundle\DependencyInjection\Compiler\KeyStoreCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PecserkeIcsDhcpServerManagementBundle extends Bundle {
    public function build(ContainerBuilder $container) {
        parent::build($container);

        $container->addCompilerPass(new KeyStoreCompilerPass());
    }
}
