<?php
namespace Pecserke\Component\IcsDhcpServer\Configuration;

class Hardware {
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $address;

    /**
     * @param string $type
     * @param string $address
     */
    public function __construct($type, $address) {
        $this->setType($type);
        $this->setAddress($address);
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address) {
        $this->address = $address;
    }
}
