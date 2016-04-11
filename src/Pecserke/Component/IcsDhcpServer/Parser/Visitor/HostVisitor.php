<?php
namespace Pecserke\Component\IcsDhcpServer\Parser\Visitor;

use Hoa\Visitor\Element;
use Hoa\Visitor\Visit;
use Pecserke\Component\IcsDhcpServer\Configuration\Host;

class HostVisitor implements Visit {
    public function visit(Element $element, &$handle = null, $eldnah = null) {
        if ($element->getId() !== '#host') {
            throw new \InvalidArgumentException($element->getId());
        }
        $host = new Host();

        foreach ($element->getChildren() as $child) {
            switch ($child->getId()) {
                case '#hostName':
                    $host->setName($child->getChild(0)->getValueValue());
                    break;
                case '#hardware':
                    $host->setHardware($child->accept(new HardwareVisitor(), $handle, $eldnah));
                    break;
                case '#fixedAddress':
                    $addresses = [];
                    foreach ($child->getChildren() as $address) {
                        $addresses[] = $address->getValueValue();
                    }
                    $host->setFixedAddress($addresses);
                    break;
                case '#ddnsHostname':
                    $host->setDdnsHostname($child->getChild(0)->getValueValue());
                    break;
                default:
                    throw new \InvalidArgumentException($child->getId());
            }
        }

        return $host;
    }
}
