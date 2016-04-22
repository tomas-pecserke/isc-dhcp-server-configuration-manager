<?php
/*
 * This file is part of the isc-dhcp-server-configuration-manager package.
 *
 * (c) Tomas Pecserke <tomas@pecserke.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class KeyStoreCompilerPass implements CompilerPassInterface {
    public function process(ContainerBuilder $container) {
        if (!$container->has('pecserke_ics_dhcp_server_management.ssh.key_store.chain')) {
            return;
        }

        $definition = $container->findDefinition('pecserke_ics_dhcp_server_management.ssh.key_store.chain');
        $taggedServices = $container->findTaggedServiceIds('pecserke_ics_dhcp_server_management.ssh_key_store');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('registerKeyStore', [new Reference($id)]);
        }
    }
}
