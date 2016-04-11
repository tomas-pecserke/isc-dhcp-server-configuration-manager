<?php
namespace Pecserke\Component\IcsDhcpServer\Tests\Configuration;

use Pecserke\Component\IcsDhcpServer\Configuration\Hardware;
use Pecserke\Component\IcsDhcpServer\Configuration\Host;

class HostTest extends \PHPUnit_Framework_TestCase {
    public function testGetAndSetName() {
        $host = new Host();
        $hostname = 'test';
        $host->setName($hostname);

        $this->assertEquals($hostname, $host->getName());
    }

    public function testGetAndSetHardware() {
        $host = new Host();
        $hw = new Hardware('ethernet', '00:00:00:00:00:00');
        $host->setHardware($hw);

        $this->assertSame($hw, $host->getHardware());
    }

    public function testGetAndSetFixedAddressSingle() {
        $host = new Host();
        $address = '1.2.3.4';
        $host->setFixedAddress($address);

        $this->assertEquals([$address], $host->getFixedAddress());
    }

    public function testGetAndSetFixedAddressMultiple() {
        $host = new Host();
        $address = ['1.2.3.4', 'example.com'];
        $host->setFixedAddress($address);

        $this->assertEquals($address, $host->getFixedAddress());
    }

    public function testGetAndSetDdnsHostname() {
        $host = new Host();
        $hostname = 'test';
        $host->setDdnsHostname($hostname);

        $this->assertEquals($hostname, $host->getDdnsHostname());
    }
}
