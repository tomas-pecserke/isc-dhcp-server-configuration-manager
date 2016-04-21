<?php
namespace Pecserke\Component\IcsDhcpServer\Lease;

use Pecserke\Component\IcsDhcpServer\Configuration\Hardware;

class Lease {
    /**
     * @var Ip
     */
    private $ip;

    /**
     * @var \DateTime
     */
    private $starts;

    /**
     * @var \DateTime
     */
    private $ends;

    /**
     * @var \DateTime
     */
    private $tstp;

    /**
     * @var \DateTime
     */
    private $tsfp;

    /**
     * @var \DateTime
     */
    private $atsfp;

    /**
     * @var \DateTime
     */
    private $cltt;

    /**
     * @var string
     */
    private $bindingState;

    /**
     * @var string
     */
    private $nextBindingState;

    /**
     * @var string
     */
    private $rewindBindingState;

    /**
     * @var Hardware
     */
    private $hardware;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var string
     */
    private $clientHostname;

    /**
     * @var string
     */
    private $uid;

    /**
     * @return Ip
     */
    public function getIp() {
        return $this->ip;
    }

    /**
     * @param Ip $ip
     */
    public function setIp($ip) {
        $this->ip = $ip;
    }

    /**
     * @return \DateTime
     */
    public function getStarts() {
        return $this->starts;
    }

    /**
     * @param \DateTime $starts
     */
    public function setStarts(\DateTime $starts) {
        $this->starts = $starts;
    }

    /**
     * @return \DateTime
     */
    public function getEnds() {
        return $this->ends;
    }

    /**
     * @param \DateTime $ends
     */
    public function setEnds($ends) {
        $this->ends = $ends;
    }

    /**
     * @return \DateTime
     */
    public function getTstp() {
        return $this->tstp;
    }

    /**
     * @param \DateTime $tstp
     */
    public function setTstp($tstp) {
        $this->tstp = $tstp;
    }

    /**
     * @return \DateTime
     */
    public function getTsfp() {
        return $this->tsfp;
    }

    /**
     * @param \DateTime $tsfp
     */
    public function setTsfp($tsfp) {
        $this->tsfp = $tsfp;
    }

    /**
     * @return \DateTime
     */
    public function getAtsfp() {
        return $this->atsfp;
    }

    /**
     * @param \DateTime $atsfp
     */
    public function setAtsfp($atsfp) {
        $this->atsfp = $atsfp;
    }

    /**
     * @return \DateTime
     */
    public function getCltt() {
        return $this->cltt;
    }

    /**
     * @param \DateTime $cltt
     */
    public function setCltt($cltt) {
        $this->cltt = $cltt;
    }

    /**
     * @return string
     */
    public function getBindingState() {
        return $this->bindingState;
    }

    /**
     * @param string $bindingState
     */
    public function setBindingState($bindingState) {
        $this->bindingState = $bindingState;
    }

    /**
     * @return string
     */
    public function getNextBindingState() {
        return $this->nextBindingState;
    }

    /**
     * @param string $nextBindingState
     */
    public function setNextBindingState($nextBindingState) {
        $this->nextBindingState = $nextBindingState;
    }

    /**
     * @return string
     */
    public function getRewindBindingState() {
        return $this->rewindBindingState;
    }

    /**
     * @param string $rewindBindingState
     */
    public function setRewindBindingState($rewindBindingState) {
        $this->rewindBindingState = $rewindBindingState;
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
    public function setHardware($hardware) {
        $this->hardware = $hardware;
    }

    /**
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasOption($name) {
        return array_key_exists($name, $this->options);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getOption($name) {
        if ($this->hasOption($name)) {
            throw new \OutOfBoundsException();
        }

        return $this->options[$name];
    }

    public function setOption($name, $value) {
        $this->options[$name] = $value;
    }

    public function removeOption($name) {
        unset($this->options[$name]);
    }

    /**
     * @return string
     */
    public function getClientHostname() {
        return $this->clientHostname;
    }

    /**
     * @param string $clientHostname
     */
    public function setClientHostname($clientHostname) {
        $this->clientHostname = $clientHostname;
    }

    /**
     * @return string
     */
    public function getUid() {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid($uid) {
        $this->uid = $uid;
    }
}
