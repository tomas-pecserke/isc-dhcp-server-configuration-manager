<?php
namespace Pecserke\Component\IcsDhcpServer\Parser\Visitor\Configuration;

use Hoa\Compiler\Llk\TreeNode;
use Hoa\Visitor\Element;
use Hoa\Visitor\Visit;
use Pecserke\Component\IcsDhcpServer\Configuration\Host;

class HostVisitor implements Visit {
    /**
     * @var Visit
     */
    private $hwVisitor;

    public function __construct() {
        $this->hwVisitor = new HardwareVisitor();
    }

    public function visit(Element $element, &$handle = null, $eldnah = null) {
        if (!$element instanceof TreeNode || $element->getId() !== '#host') {
            throw new \InvalidArgumentException($element->getId());
        }
        $host = new Host();

        foreach ($element->getChildren() as $child) {
            /* @var TreeNode $child */
            switch ($child->getId()) {
                case '#hostName':
                    $host->setName($child->getChild(0)->getValueValue());
                    break;
                case '#hardware':
                    $hardware = $child->accept($this->hwVisitor, $handle, $eldnah);
                    $host->setHardware($hardware);
                    break;
                case '#fixedAddress':
                    $addresses = [];
                    foreach ($child->getChildren() as $address) {
                        /* @var TreeNode $address */
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
