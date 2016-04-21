<?php
namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Repository;

use Pecserke\Component\FileLoader\Loader;
use Pecserke\Component\IcsDhcpServer\Lease\Lease;
use Pecserke\Component\IcsDhcpServer\Parser\LeaseParser;

class LeaseRepository {
    /**
     * @var Loader
     */
    private $loader;

    /**
     * @var LeaseParser
     */
    private $parser;

    /**
     * @var string
     */
    private $leaseFile = 'scp://ubuntu@ns1.office.maind.sk/var/lib/dhcp/dhcpd.leases'; // FIXME

    public function __construct(LeaseParser $parser, Loader $loader) {
        $this->parser = $parser;
        $this->loader = $loader;
    }

    /**
     * @return \Pecserke\Component\IcsDhcpServer\Lease\Lease[]
     */
    public function getLeases() {
        $content = $this->loader->load($this->leaseFile);
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
