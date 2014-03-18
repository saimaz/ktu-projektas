<?php
namespace KTU\DaemonBundle\Command;

use KTU\AppBundle\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterCommand extends AbstractCommand {
    public function configure()
    {
        $this->setName('daemon:register');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $dialog \Symfony\Component\Console\Helper\DialogHelper */
        /* @var $model \KTU\DaemonBundle\Model\DaemonModel */
        $dialog = $this->getHelperSet()->get('dialog');
        $model = $this->getContainer()->get('daemon.model');
        $actions = array_keys($model->getActions());

        $action = $dialog->ask(
            $output,
            '<info>Action</info>: ',
            null,
            $actions
        );

        if($action && in_array($action, $actions)) {
            $model->registerAction($action);
            $this->getDoctrine()->getManager()->flush();
            $output->writeln('<info>Action registered</info>');
        } else {
            $output->writeln('<error>Wrong action</error>');
        }
    }
} 