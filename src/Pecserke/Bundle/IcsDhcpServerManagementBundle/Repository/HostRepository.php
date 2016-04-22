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

use Pecserke\Component\FileLoader\Loader;
use Pecserke\Component\IcsDhcpServer\Configuration\Host;
use Pecserke\Component\IcsDhcpServer\Parser\HostParser;

class HostRepository {
    /**
     * @var string
     */
    private $hostsFileUri;

    /**
     * @var Loader
     */
    private $loader;
    /**
     * @var HostParser
     */
    private $parser;

    public function __construct(HostParser $parser, Loader $loader, $hostsFileUri) {
        $this->parser = $parser;
        $this->loader = $loader;
        $this->hostsFileUri = $hostsFileUri;
    }

    /**
     * @return Host[]
     */
    public function getHosts() {
        $content = $this->loader->load($this->hostsFileUri);
        $config = $this->parser->parse($content);

        return $config->getHosts();
    }
}
