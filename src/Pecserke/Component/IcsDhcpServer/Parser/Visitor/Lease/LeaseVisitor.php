<?php
namespace Pecserke\Component\IcsDhcpServer\Parser\Visitor\Lease;

use Hoa\Compiler\Llk\TreeNode;
use Hoa\Visitor\Element;
use Hoa\Visitor\Visit;
use Pecserke\Component\IcsDhcpServer\Configuration\Hardware;
use Pecserke\Component\IcsDhcpServer\Lease\Ip;
use Pecserke\Component\IcsDhcpServer\Lease\Lease;

class LeaseVisitor implements Visit {
    public function visit(Element $element, &$handle = null, $eldnah = null) {
        if (!$element instanceof TreeNode || $element->getId() !== '#lease') {
            throw new \InvalidArgumentException($element->getId());
        }
        $lease = new Lease();

        foreach ($element->getChildren() as $child) {
            /* @var TreeNode $child */
            switch ($child->getId()) {
                case '#ip':
                    $ip = new Ip($child->getChild(0)->getValueValue());
                    $lease->setIp($ip);
                    break;
                case '#starts':
                    $date = $this->parseDate($child->getChild(0)->getValueValue());
                    $lease->setStarts($date);
                    break;
                case '#ends':
                    $date = $this->parseDate($child->getChild(0)->getValueValue());
                    $lease->setEnds($date);
                    break;
                case '#tstp':
                    $date = $this->parseDate($child->getChild(0)->getValueValue());
                    $lease->setTstp($date);
                    break;
                case '#tsfp':
                    $date = $this->parseDate($child->getChild(0)->getValueValue());
                    $lease->setTsfp($date);
                    break;
                case '#atsfp':
                    $date = $this->parseDate($child->getChild(0)->getValueValue());
                    $lease->setAtsfp($date);
                    break;
                case '#cltt':
                    $date = $this->parseDate($child->getChild(0)->getValueValue());
                    $lease->setCltt($date);
                    break;
                case '#bindingState':
                    $lease->setBindingState($child->getChild(0)->getValueValue());
                    break;
                case '#nextBindingState':
                    $lease->setNextBindingState($child->getChild(0)->getValueValue());
                    break;
                case '#rewindBindingState':
                    $lease->setRewindBindingState($child->getChild(0)->getValueValue());
                    break;
                case '#hardware':
                    $hw = new Hardware(
                        $child->getChild(0)->getChild(0)->getValueValue(),
                        $child->getChild(1)->getChild(0)->getValueValue()
                    );
                    $lease->setHardware($hw);
                    break;
                case '#set':
                    $lease->setOption(
                        $child->getChild(0)->getChild(0)->getValueValue(),
                        $child->getChild(1)->getChild(0)->getValueValue()
                    );
                    break;
                case '#clientHostname':
                    $lease->setClientHostname($child->getChild(0)->getValueValue());
                    break;
                case '#uid':
                    $lease->setUid($child->getChild(0)->getValueValue());
                    break;
                default:
                    throw new \InvalidArgumentException($child->getId());
            }
        }

        return $lease;
    }

    private function parseDate($date) {
        if (preg_match('/^\d+$/', $date)) {
            return \DateTime::createFromFormat('U', $date);
        }

        return \DateTime::createFromFormat('Y/n/j G:i:s', substr($date, 2));
    }
}
