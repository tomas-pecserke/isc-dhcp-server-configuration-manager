<?php
namespace Pecserke\Component\IcsDhcpServer\Parser\Visitor;

use Hoa\Visitor\Element;
use Hoa\Visitor\Visit;
use Pecserke\Component\IcsDhcpServer\Configuration\Hardware;

class HardwareVisitor implements Visit {
    public function visit(Element $element, &$handle = null, $eldnah = null) {
        if ($element->getId() !== '#hardware') {
            throw new \InvalidArgumentException($element->getId());
        }

        return new Hardware(
            $element->getChild(0)->getChild(0)->getValueValue(),
            $element->getChild(1)->getChild(0)->getValueValue()
        );
    }
}
