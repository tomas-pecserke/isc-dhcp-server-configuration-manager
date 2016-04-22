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
use Pecserke\Component\IcsDhcpServer\Lease\Lease;
use Pecserke\Component\IcsDhcpServer\Parser\LeaseParser;

class LeaseRepository {
    /**
     * @var string
     */
    private $leaseFileUri;

    /**
     * @var Loader
     */
    private $loader;

    /**
     * @var LeaseParser
     */
    private $parser;

    public function __construct(LeaseParser $parser, Loader $loader, $leaseFileUri) {
        $this->parser = $parser;
        $this->loader = $loader;
        $this->leaseFileUri = $leaseFileUri;
    }

    /**
     * @return \Pecserke\Component\IcsDhcpServer\Lease\Lease[]
     */
    public function getLeases() {
        $content = $this->loader->load($this->leaseFileUri);
        $leaseFile = $this->parser->parse($content);

        return $leaseFile->getLeases();
    }

    /**
     * @return \Pecserke\Component\IcsDhcpServer\Lease\Lease[]
     */
    public function getActiveFreeLeases() {
        return array_filter($this->getLeases(), function(Lease $lease) {
            return strtolower($lease->getBindingState()) === 'active';
        });
    }
}
