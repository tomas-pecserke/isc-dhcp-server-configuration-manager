<?php
namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Command\Lease;

use Pecserke\Component\IcsDhcpServer\Lease\Lease;
use Pecserke\Component\IcsDhcpServer\Parser\LeaseParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command {
    const DATE_FORMAT = 'Y-m-j H:i:s';

    protected function configure() {
        $this->setName('lease:list');
        $this->setDescription('List leases');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $parser = new LeaseParser();
        $leaseFile = $parser->parseFile(__DIR__ . '/../../../../Component/IcsDhcpServer/Tests/Fixtures/dhcpd.leases');

        $leases = array_filter($leaseFile->getLeases(), function(Lease $lease) {
            return $lease->getBindingState() === 'active';
        });
        uksort($leases, function($address1, $address2) {
            $parts1 = explode('.', $address1);
            $parts2 = explode('.', $address2);
            for ($i = 0; $i < 4; $i++) {
                $part1 = (int) $parts1[$i];
                $part2 = (int) $parts2[$i];
                if ($part1 !== $part2) {
                    return $part1 - $part2;
                }
            }

            return 0;
        });

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
