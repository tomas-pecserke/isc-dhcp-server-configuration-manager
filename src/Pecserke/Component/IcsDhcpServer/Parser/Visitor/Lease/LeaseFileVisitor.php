<?php
namespace Pecserke\Component\IcsDhcpServer\Parser\Visitor\Lease;

use Hoa\Compiler\Llk\TreeNode;
use Hoa\Visitor\Element;
use Hoa\Visitor\Visit;
use Pecserke\Component\IcsDhcpServer\Lease\LeaseFile;

class LeaseFileVisitor implements Visit {
    /**
     * @var Visit
     */
    private $leaseVisitor;

    /**
     * LeaseFileVisitor constructor.
     */
    public function __construct() {
        $this->leaseVisitor = new LeaseVisitor();
    }

    public function visit(Element $element, &$handle = null, $eldnah = null) {
        if (!$element instanceof TreeNode || $element->getId() !== '#leaseFile') {
            throw new \InvalidArgumentException($element->getId());
        }
        $leaseFile = new LeaseFile();

        foreach ($element->getChildren() as $child) {
            /* @var TreeNode $child */
            switch ($child->getId()) {
                case '#lease':
                    $lease = $child->accept($this->leaseVisitor, $handle, $eldnah);
                    $leaseFile->addLease($lease);
                    break;
                default:
                    throw new \InvalidArgumentException($child->getId());
            }
        }

        return $leaseFile;
    }
}
