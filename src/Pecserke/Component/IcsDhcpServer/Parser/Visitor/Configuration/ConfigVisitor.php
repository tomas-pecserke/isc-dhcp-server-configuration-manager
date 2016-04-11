<?php
namespace Pecserke\Component\IcsDhcpServer\Parser\Visitor\Configuration;

use Hoa\Compiler\Llk\TreeNode;
use Hoa\Visitor\Element;
use Hoa\Visitor\Visit;
use Pecserke\Component\IcsDhcpServer\Configuration\Config;

class ConfigVisitor implements Visit {
    /**
     * @var Visit
     */
    private $hostVisitor;

    public function __construct() {
        $this->hostVisitor = new HostVisitor();
    }

    public function visit(Element $element, &$handle = null, $eldnah = null) {
        if (!$element instanceof TreeNode || $element->getId() !== '#config') {
            throw new \InvalidArgumentException($element->getId());
        }
        $config = new Config();

        foreach ($element->getChildren() as $child) {
            /* @var TreeNode $child */
            switch ($child->getId()) {
                case '#host':
                    $host = $child->accept($this->hostVisitor, $handle, $eldnah);
                    $config->addHost($host);
                    break;
                default:
                    throw new \InvalidArgumentException($child->getId());
            }
        }

        return $config;
    }
}
