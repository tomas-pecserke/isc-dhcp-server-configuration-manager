<?php
/*
 * This file is part of the isc-dhcp-server-configuration-manager package.
 *
 * (c) Tomas Pecserke <tomas@pecserke.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class PecserkeIcsDhcpServerManagementExtension extends Extension {
    public function load(array $configs, ContainerBuilder $container) {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $jsonFile = dirname($container->getParameter('kernel.root_dir')) . '/var/conf/ssh_keys.json';
        $container->setParameter('pecserke_ics_dhcp_server_management.ssh.key_store.json.file', $jsonFile);

        $container->setParameter('pecserke_ics_dhcp_server_management.repository.lease.uri', $config['lease']['uri']);
        $container->setParameter('pecserke_ics_dhcp_server_management.repository.hosts.uri', $config['hosts']['uri']);
    }
}
