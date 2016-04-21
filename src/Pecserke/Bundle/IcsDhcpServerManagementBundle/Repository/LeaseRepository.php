<?php
namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Repository;

use Pecserke\Component\IcsDhcpServer\Lease\Lease;
use Pecserke\Component\IcsDhcpServer\Parser\LeaseParser;

class LeaseRepository {
    /**
     * @var LeaseParser
     */
    private $parser;

    /**
     * @var string
     */
    private $leaseFile = __DIR__ . '/../../../Component/IcsDhcpServer/Tests/Fixtures/dhcpd.leases';

    public function __construct(LeaseParser $parser) {
        $this->parser = $parser;
    }

    /**
     * @return \Pecserke\Component\IcsDhcpServer\Lease\Lease[]
     */
    public function getLeases() {
        return $this->parser->parseFile($this->leaseFile)->getLeases();
    }

    /**
     * @return \Pecserke\Component\IcsDhcpServer\Lease\Lease[]
     */
    public function getNonFreeLeases() {
        return array_filter($this->getLeases(), function(Lease $lease) {
            return strtolower($lease->getBindingState()) !== 'free';
        });
    }
}
