<?php
namespace Pecserke\Component\IcsDhcpServer\Parser;

use Hoa\Visitor\Visit;
use Pecserke\Component\IcsDhcpServer\Configuration\Config;
use Pecserke\Component\IcsDhcpServer\Parser\Visitor\Configuration\ConfigVisitor;

class HostParser extends AbstractParser {
    /**
     * @var Visit
     */
    private $visitor;

    public function __construct() {
        parent::__construct();
        $this->visitor = new ConfigVisitor();
    }

    protected function getGrammar() {
        return __DIR__ . '/../Resources/grammar/isc-dhcp-server-min.pp';
    }

    protected function getVisitor() {
        return $this->visitor;
    }

    /**
     * @param string $source
     * @return Config
     * @throws FormatException
     */
    public function parse($source) {
        return parent::parse($source);
    }

    /**
     * @param resource $handle
     * @return Config
     * @throws FormatException
     */
    public function parseStream($handle) {
        return parent::parseStream($handle);
    }

    /**
     * @param string $filename
     * @return Config
     * @throws FormatException
     */
    public function parseFile($filename) {
        return parent::parseFile($filename);
    }
}
