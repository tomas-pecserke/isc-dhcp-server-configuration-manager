<?php
namespace Pecserke\Component\IcsDhcpServer\Parser;

use Hoa\Compiler\Llk\Llk;
use Hoa\Compiler\Llk\Parser;
use Hoa\File\Read;
use Hoa\Visitor\Visit;

abstract class AbstractParser {
    /**
     * @var Parser
     */
    private $parser;

    public function __construct() {
        $this->parser = Llk::load(new Read($this->getGrammar()));
    }

    /**
     * @return string
     */
    protected abstract function getGrammar();

    /**
     * @return Visit
     */
    protected abstract function getVisitor();

    /**
     * @param string $source
     * @return mixed
     * @throws FormatException
     */
    public function parse($source) {
        try {
            $ast = $this->parser->parse($source);

            return $this->getVisitor()->visit($ast);
        } catch (\Exception $e) {
            throw new FormatException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param resource $handle
     * @return mixed
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
     * @return mixed
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
