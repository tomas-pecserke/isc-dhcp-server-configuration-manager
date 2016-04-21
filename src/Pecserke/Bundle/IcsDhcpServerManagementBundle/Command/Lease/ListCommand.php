<?php
namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Command\Lease;

use Pecserke\Component\IcsDhcpServer\Lease\Lease;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends ContainerAwareCommand {
    const DATE_FORMAT = 'Y-m-j H:i:s';

    protected function configure() {
        $this->setName('lease:list');
        $this->setDescription('List leases');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $leases = $this->getContainer()->get('pecserke_ics_dhcp_server_management.repository.lease')->getNonFreeLeases();

        $table = new Table($output);
        $table->setHeaders(['IP', 'Hostname', 'Expires', 'State']);
        $table->setRows(array_map([$this, 'prepareTableData'], $leases));
        $table->render();
    }

    /**
     * @param Lease $lease
     * @return array
     */
    private function prepareTableData(Lease $lease) {
        return [
            $lease->getIp()->getAddress(),
            $lease->getClientHostname(),
            $lease->getEnds()->format(self::DATE_FORMAT),
            $lease->getBindingState(),
        ];
    }
}
