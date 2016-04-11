<?php
namespace Pecserke\Component\IcsDhcpServer\Configuration;

class Config {
    /**
     * @var Host[]
     */
    private $hosts = [];

    /**
     * @return Host[]
     */
    public function getHosts() {
        return $this->hosts;
    }

    /**
     * @param string $hostName
     * @return bool
     */
    public function hasHost($hostName) {
        return isset($this->hosts[$hostName]);
    }

    /**
     * @param string $hostName
     * @return Host
     * @throws \OutOfBoundsException
     */
    public function getHost($hostName) {
        if (!$this->hasHost($hostName)) {
            throw new \OutOfBoundsException($hostName);
        }

        return $this->hosts[$hostName];
    }

    public function addHost(Host $host) {
        $this->hosts[$host->getName()] = $host;
    }

    /**
     * @param string $hostName
     */
    public function removeHost($hostName) {
        unset($this->hosts[$hostName]);
    }
}
