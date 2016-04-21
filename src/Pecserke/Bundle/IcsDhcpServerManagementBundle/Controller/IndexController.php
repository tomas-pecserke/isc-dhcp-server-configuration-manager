<?php
namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {
    /**
     * @Route(path="/", name="homepage", methods={"GET"})
     */
    public function indexAction() {
        $leases = $this->get('pecserke_ics_dhcp_server_management.repository.lease')->getNonFreeLeases();

        return $this->render('PecserkeIcsDhcpServerManagementBundle:Index:index.html.twig', [
            'leases' => $leases
        ]);
    }
}
