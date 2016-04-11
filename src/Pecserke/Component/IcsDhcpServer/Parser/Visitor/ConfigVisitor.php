<?php
namespace Pecserke\Component\IcsDhcpServer\Parser\Visitor;

use Hoa\Visitor\Element;
use Hoa\Visitor\Visit;
use Pecserke\Component\IcsDhcpServer\Configuration\Config;

class ConfigVisitor implements Visit {
    public function visit(Element $element, &$handle = null, $eldnah = null) {
        if ($element->getId() !== '#config') {
            throw new \InvalidArgumentException($element->getId());
        }
        $config = new Config();

        foreach ($element->getChildren() as $child) {
            switch ($child->getId()) {
                case '#host':
                    $config->addHost($child->accept(new HostVisitor(), $handle, $eldnah));
                    break;
                default:
                    throw new \InvalidArgumentException($child->getId());
            }
        }

        return $config;
    }
}
