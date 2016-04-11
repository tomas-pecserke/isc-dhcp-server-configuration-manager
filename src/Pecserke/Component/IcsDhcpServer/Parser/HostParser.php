<?php
namespace Pecserke\Component\IcsDhcpServer\Parser;

use Hoa\Compiler\Llk\Llk;
use Hoa\File\Read;
use Pecserke\Component\IcsDhcpServer\Configuration\Config;
use Pecserke\Component\IcsDhcpServer\Parser\Visitor\Configuration\ConfigVisitor;

class HostParser {
    /**
     * @var \Hoa\Compiler\Llk\Parser
     */
    private $parser;

    /**
     * @var ConfigVisitor
     */
    private $visitor;

    public function __construct() {
        $path = __DIR__ . '/../Resources/grammar/isc-dhcp-server-min.pp';
        $this->parser = Llk::load(new Read($path));
        $this->visitor = new ConfigVisitor();
    }

    /**
     * @param string $source
     * @return Config
     * @throws FormatException
     */
    public function parse($source) {
        try {
            $ast = $this->parser->parse($source);

            return $this->visitor->visit($ast);
        } catch (\Exception $e) {
            throw new FormatException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param resource $handle
     * @return Config
     * @throws FormatException
     */
    public function parseStream($handle) {
        $source = stream_get_contents($handle);
        if ($source === false) {
            throw new FormatException('failed to read stream');
        }

        return $this->parse($source);
    }

    /**
     * @param string $filename
     * @return Config
     * @throws FormatException
     */
    public function parseFile($filename) {
        $source = file_get_contents($filename);
        if ($source === false) {
            throw new FormatException(sprintf("failed to read file '%s'", $filename));
        }

        return $this->parse($source);
    }
}
