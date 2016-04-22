<?php
/*
 * This file is part of the isc-dhcp-server-configuration-manager package.
 *
 * (c) Tomas Pecserke <tomas@pecserke.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Repository;

use Pecserke\Component\IcsDhcpServer\Configuration\Host;
use Pecserke\Component\IcsDhcpServer\Parser\HostParser;

class HostRepository {
    /**
     * @var HostParser
     */
    private $parser;

    /**
     * @var string[]
     */
    private $hostFiles;

    public function __construct(HostParser $parser) {
        $this->parser = $parser;
        $this->hostFiles = [
            __DIR__ . '/../../../Component/IcsDhcpServer/Tests/Fixtures/hosts.conf' // FIXME
        ];
    }

    /**
     * @return Host[]
     */
    public function getHosts() {
        $hosts = [];
        foreach ($this->hostFiles as $hostFile) {
            $config = $this->parser->parseFile($hostFile);
            $hosts = array_merge($hosts, $config->getHosts());
        }

        return $hosts;
    }
}
