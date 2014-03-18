<?php
namespace KTU\DaemonBundle\Command;

use KTU\AppBundle\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DaemonCommand extends AbstractCommand {
    public function configure()
    {
        $this->setName('daemon:run');
        $this->addOption('no-daemon', null, InputOption::VALUE_OPTIONAL, 'Cancel daemon fork');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $model \KTU\DaemonBundle\Model\DaemonModel */
        $actions = $this->getContainer()->getParameter('daemon_actions');
        $actionNames = array_keys($actions);
        $model = $this->getContainer()->get('daemon.model');

        while(true) {
            sleep(1);
            /* @var $action \KTU\DatabaseBundle\Entity\DaemonAction */
            $action = $model->getNewAction();

            if($action && in_array($action->getAction(), $actionNames)) {
                $model->run($action);
                $class = $actions[$action->getAction()]['class'];
                /* @var $object \KTU\DaemonBundle\Action\AbstractAction */
                $object = new $class($this->getContainer(), $action);
                $object->run();
                $model->close($action);
            }
        }
    }
} 