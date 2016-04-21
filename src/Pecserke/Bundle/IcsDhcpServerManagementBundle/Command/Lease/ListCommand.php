<?php
namespace Pecserke\Bundle\IcsDhcpServerManagementBundle\Command\Lease;

use Pecserke\Bundle\IcsDhcpServerManagementBundle\Repository\LeaseRepository;
use Pecserke\Component\IcsDhcpServer\Lease\Lease;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command {
    const DATE_FORMAT = 'Y-m-j H:i:s';

    /**
     * @var LeaseRepository
     */
    private $repository;

    /**
     * ListCommand constructor.
     * @param LeaseRepository $repository
     */
    public function __construct(LeaseRepository $repository) {
        parent::__construct();
        $this->repository = $repository;
    }

    protected function configure() {
        $this->setName('lease:list');
        $this->setDescription('List leases');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $table = new Table($output);
        $table->setHeaders(['IP', 'Hostname', 'Expires', 'State']);
        $table->setRows(array_map([$this, 'prepareTableData'], $this->repository->getActiveFreeLeases()));
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
