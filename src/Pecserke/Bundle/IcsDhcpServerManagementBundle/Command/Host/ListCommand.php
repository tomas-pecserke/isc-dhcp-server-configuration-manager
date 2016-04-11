<?php
namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Command\Host;

use Pecserke\Component\IcsDhcpServer\Configuration\Host;
use Pecserke\Component\IcsDhcpServer\Parser\Parser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command {
    protected function configure() {
        $this->setName('host:list');
        $this->setDescription('List static hosts');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $parser = new Parser();
        $config = $parser->parseFile(__DIR__ . '/../../Tests/Fixtures/hosts.conf');

        $table = new Table($output);
        $table->setHeaders(['Name', 'HW Type', 'HW Address', 'Fixed Address', 'DDNS Hostname']);
        $table->setRows(array_map([$this, 'prepareHostData'], $config->getHosts()));
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
