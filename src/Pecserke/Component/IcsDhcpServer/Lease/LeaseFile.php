<?php
namespace Pecserke\Component\IcsDhcpServer\Lease;

class LeaseFile {
    /**
     * @var Lease[]
     */
    private $leases = [];

    /**
     * @return Lease[]
     */
    public function getLeases() {
        return $this->leases;
    }

    public function addLease(Lease $lease) {
        if ($lease->getIp() === null) {
            throw new \InvalidArgumentException('no lease ip');
        }

        $this->leases[$lease->getIp()->getAddress()] = $lease;
    }

    public function removeLease(Ip $ip) {
        unset($this->leases[$ip->getAddress()]);
    }
}
