<?php
namespace Pecserke\Component\IcsDhcpServer\Configuration;

class Host {
    /**
     * @var string
     */
    private $name;

    /**
     * @var Hardware
     */
    private $hardware;

    /**
     * @var string[]
     */
    private $fixedAddress;

    /**
     * @var string
     */
    private $ddnsHostname;

    /**
     * Host constructor.
     * @param string|null $name
     */
    public function __construct($name = null) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return Hardware
     */
    public function getHardware() {
        return $this->hardware;
    }

    /**
     * @param Hardware $hardware
     */
    public function setHardware(Hardware $hardware) {
        $this->hardware = $hardware;
    }

    /**
     * @return string[]
     */
    public function getFixedAddress() {
        return $this->fixedAddress;
    }

    /**
     * @param string|string[] $fixedAddress
     */
    public function setFixedAddress($fixedAddress) {
        if (!is_array($fixedAddress)) {
            $fixedAddress = [$fixedAddress];
        }
        $this->fixedAddress = $fixedAddress;
    }

    /**
     * @return string
     */
    public function getDdnsHostname() {
        return $this->ddnsHostname;
    }

    /**
     * @param string $ddnsHostname
     */
    public function setDdnsHostname($ddnsHostname) {
        $this->ddnsHostname = $ddnsHostname;
    }
}
