<?php
namespace Pecserke\Component\IcsDhcpServer\Export;

use Pecserke\Component\IcsDhcpServer\Configuration\Config;

class ConfigExporter {
    /**
     * @var HostExporter
     */
    private $hostExporter;

    public function __construct() {
        $this->hostExporter = new HostExporter();
    }

    /**
     * @param Config $config
     * @param int $depth
     * @return string
     */
    public function export(Config $config, $depth = 0) {
        $result = '';
        foreach ($config->getHosts() as $host) {
            if (!empty($result)) {
                $result .= "\n";
            }
            $result .= $this->hostExporter->export($host, $depth);
        }

        return $result;
    }
}
