<?php
namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Command\Host;

use Pecserke\Component\IcsDhcpServer\Configuration\Host;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends ContainerAwareCommand {
    protected function configure() {
        $this->setName('host:list');
        $this->setDescription('List static hosts');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $hosts = $this->getContainer()->get('pecserke_ics_dhcp_server_management.repository.host')->getHosts();

        $table = new Table($output);
        $table->setHeaders(['Name', 'HW Type', 'HW Address', 'Fixed Address', 'DDNS Hostname']);
        $table->setRows(array_map([$this, 'prepareHostData'], $hosts));
        $table->render();
    }

    /**
     * @param Host $host
     * @return array
     */
    private function prepareHostData(Host $host) {
        return [
            $host->getName(),
            $host->getHardware() === null ? null : $host->getHardware()->getType(),
            $host->getHardware() === null ? null : $host->getHardware()->getAddress(),
            implode(', ', $host->getFixedAddress()),
            $host->getDdnsHostname()
        ];
    }
}
