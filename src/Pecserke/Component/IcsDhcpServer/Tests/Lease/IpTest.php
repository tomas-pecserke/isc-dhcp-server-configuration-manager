<?php
namespace Pecserke\Component\IcsDhcpServer\Tests\Lease;

use Pecserke\Component\IcsDhcpServer\Lease\Ip;

class IpTest extends \PHPUnit_Framework_TestCase {
    public function testConstructorAndGetAddress() {
        $address = '1.12.123.234';
        $ip = new Ip($address);

        $this->assertEquals($address, $ip->getAddress());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage ip address must be between 0.0.0.0 and 255.255.255.255, got '1.2.3.256'
     */
    public function testConstructorAndGetAddressInvalid() {
        new Ip('1.2.3.256');
    }
}
