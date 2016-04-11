<?php
namespace Pecserke\Component\IcsDhcpServer\Tests\Export;

use Pecserke\Component\IcsDhcpServer\Configuration\Config;
use Pecserke\Component\IcsDhcpServer\Configuration\Hardware;
use Pecserke\Component\IcsDhcpServer\Configuration\Host;
use Pecserke\Component\IcsDhcpServer\Export\ConfigExporter;

class ConfigExporterTest extends \PHPUnit_Framework_TestCase {
    public function testExport() {
        $config = new Config();

        $host = new Host('test1');
        $host->setHardware(new Hardware('ethernet', '00:01:02:03:04:05'));
        $host->setFixedAddress('1.2.3.4');
        $host->setDdnsHostname('test1');
        $config->addHost($host);

        $host = new Host('test2');
        $host->setHardware(new Hardware('ethernet', '01:02:03:04:05:06'));
        $host->setFixedAddress('2.3.4.5');
        $host->setDdnsHostname('test2');
        $config->addHost($host);

        $expected =
"host test1 {
\thardware ethernet 00:01:02:03:04:05;
\tfixed-address 1.2.3.4;
\tddns-hostname \"test1\";
}

host test2 {
\thardware ethernet 01:02:03:04:05:06;
\tfixed-address 2.3.4.5;
\tddns-hostname \"test2\";
}
";

        $exporter = new ConfigExporter();
        $this->assertEquals($expected, $exporter->export($config));
    }

    public function testExportEmpty() {
        $config = new Config();

        $exporter = new ConfigExporter();
        $this->assertEquals('', $exporter->export($config));
    }
}
