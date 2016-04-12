<?php
namespace Pecserke\Component\IcsDhcpServer\Parser;

use Hoa\Visitor\Visit;
use Pecserke\Component\IcsDhcpServer\Lease\LeaseFile;
use Pecserke\Component\IcsDhcpServer\Parser\Visitor\Lease\LeaseFileVisitor;

class LeaseParser extends AbstractParser {
    /**
     * @var Visit
     */
    private $visitor;

    public function __construct() {
        parent::__construct();
        $this->visitor = new LeaseFileVisitor();
    }

    protected function getGrammar() {
        return __DIR__ . '/../Resources/grammar/leases.pp';
    }

    protected function getVisitor() {
        return $this->visitor;
    }

    /**
     * @param string $source
     * @return LeaseFile
     * @throws FormatException
     */
    public function parse($source) {
        return parent::parse($source);
    }

    /**
     * @param resource $handle
     * @return LeaseFile
     * @throws FormatException
     */
    public function parseStream($handle) {
        return parent::parseStream($handle);
    }

    /**
     * @param string $filename
     * @return LeaseFile
     * @throws FormatException
     */
    public function parseFile($filename) {
        return parent::parseFile($filename);
    }
}
