<?php
namespace KTU\AdminBundle\Command;

use KTU\AppBundle\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddAdminCommand extends AbstractCommand
{
    protected $username = 'admin';
    protected $email = 'admin@localhost';
    protected $password = 'adminpass';

    protected function configure()
    {
        $this
            ->setName('add:admin')
            ->setDescription('Add project admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getInfo($output);
        $this->getUserModel()->addAdmin($this->username, $this->email, $this->password);
    }

    protected function getInfo(OutputInterface $output)
    {
        /* @var $dialog \Symfony\Component\Console\Helper\DialogHelper */
        $dialog = $this->getHelperSet()->get('dialog');

        $this->username = $dialog->ask(
            $output,
            '<info>Username</info> <comment>[' . $this->username . ']</comment>:',
            $this->username
        );

        $this->email = $dialog->ask(
            $output,
            '<info>Email</info> <comment>[' . $this->email . ']</comment>:',
            $this->email
        );

        $password = $dialog->askHiddenResponse(
            $output,
            '<info>Password</info> <comment>[' . $this->password .  ']</comment>:',
            false
        );

        if($password) {
            $this->password = $password;
        }
    }
} 