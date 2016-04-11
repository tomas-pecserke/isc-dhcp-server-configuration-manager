<?php
namespace Pecserke\Component\IcsDhcpServer\Tests\Configuration;

use Pecserke\Component\IcsDhcpServer\Configuration\Hardware;

class HardwareTest extends \PHPUnit_Framework_TestCase {
    public function testConstructor() {
        $type = 'ethernet';
        $address = '00:01:02:03:04:05';
        $hw = new Hardware($type, $address);

        $this->assertEquals($type, $hw->getType());
        $this->assertEquals($address, $hw->getAddress());
    }
}
