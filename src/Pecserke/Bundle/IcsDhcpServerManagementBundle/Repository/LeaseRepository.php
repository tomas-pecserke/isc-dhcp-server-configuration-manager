<?php
namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Repository;

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

    public function __construct() {
        $this->parser = new LeaseParser();
    }

    /**
     * @return \Pecserke\Component\IcsDhcpServer\Lease\Lease[]
     */
    public function getLeases() {
        return $this->parser->parseFile($this->leaseFile)->getLeases();
    }
}
