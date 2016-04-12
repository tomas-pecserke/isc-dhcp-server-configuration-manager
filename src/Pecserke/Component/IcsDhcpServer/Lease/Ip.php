<?php
namespace Pecserke\Component\IcsDhcpServer\Lease;

class Ip {
    /**
     * @var string
     */
    private $address;

    /**
     * @param string $address
     */
    public function __construct($address) {
        if (preg_match('/^(1?\\d{1,2}|2([0-4]\\d|5[0-5]))(\.(1?\\d{1,2}|2([0-4]\\d|5[0-5]))){3}$/', $address) !== 1) {
            throw new \InvalidArgumentException(sprintf(
                "ip address must be between 0.0.0.0 and 255.255.255.255, got '%s'",
                $address
            ));
        }

        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }
}
