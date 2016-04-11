<?php
namespace Pecserke\Component\IcsDhcpServer\Tests\Parser;

use Pecserke\Component\IcsDhcpServer\Configuration\Config;
use Pecserke\Component\IcsDhcpServer\Parser\HostParser;

class HostParserTest extends \PHPUnit_Framework_TestCase {
    public function testParse() {
        $source = file_get_contents(__DIR__.'/../Fixtures/hosts.conf');
        $parser = new HostParser();
        $config = $parser->parse($source);

        $this->assertInstanceOf(Config::class, $config);

        $hosts = $config->getHosts();
        $this->assertCount(2, $hosts);
        $this->assertArrayHasKey('test1', $hosts);
        $this->assertArrayHasKey('test2', $hosts);

        $vpn = $hosts['test1'];
        $this->assertEquals('test1', $vpn->getName());
        $this->assertEquals('ethernet', $vpn->getHardware()->getType());
        $this->assertEquals('00:01:02:03:04:05', $vpn->getHardware()->getAddress());
        $this->assertEquals(['1.2.3.4'], $vpn->getFixedAddress());
        $this->assertEquals('test1', $vpn->getDdnsHostname());

        $vpn = $hosts['test2'];
        $this->assertEquals('test2', $vpn->getName());
        $this->assertEquals('ethernet', $vpn->getHardware()->getType());
        $this->assertEquals('01:02:03:04:05:06', $vpn->getHardware()->getAddress());
        $this->assertEquals(['2.3.4.5'], $vpn->getFixedAddress());
        $this->assertEquals('test2', $vpn->getDdnsHostname());
    }

    public function testParseEmpty() {
        $parser = new HostParser();
        $config = $parser->parse('');

        $this->assertEmpty($config->getHosts());
    }
}
