<?php
namespace KTU\AdminBundle\Command;

use KTU\AppBundle\Command\AbstractCommand;
use KTU\AppBundle\Model\CronJobModel;
use KTU\DatabaseBundle\Entity\CronJob;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @property \Symfony\Component\Console\Input\InputInterface   $input
 * @property \Symfony\Component\Console\Output\OutputInterface $output
 */
class CronJobCommand extends AbstractCommand
{
    protected $input;
    protected $output;

    protected function configure()
    {
        $this
            ->setName('project:cron')
            ->setDescription('Updates the project');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setInputOutput($input, $output);
        $this->addStyle();

        chdir(realpath(__DIR__ . '/../../../..'));

        try {
            $job = $this->getCronJobModel()->getWaitingJob();
        } catch (\Exception $e) {
            $this->updateProject();
            $job = null;
        }

        if ($job) {
            $this->getCronJobModel()->run($job);
            $this->switchAction($job);
            $this->getCronJobModel()->end($job);
        }
    }

    protected function setInputOutput(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;
    }

    protected function addStyle()
    {
        $style = new OutputFormatterStyle('blue');
        $this->output->getFormatter()->setStyle('msg', $style);
    }

    protected function switchAction(CronJob $job)
    {
        switch ($job->getAction()) {
            case CronJobModel::ACTION_UPDATE:
                $this->updateProject();
        }
    }

    protected function updateProject()
    {
        $this->output->writeln('--------------- Update (' . date('Y-m-d H:i:s') . ') --------------');
        $this->output->writeln('<msg>Pulling git ...</msg>');
        $this->runShell('git pull', $this->output);
        $this->output->writeln('<msg>Installing assets ...</msg>');
        $this->runCommand(
            'assets:install',
            [
                'target' => 'web/',
                '--env'  => 'prod',
            ],
            $this->output
        );
        $this->output->writeln('<msg>Dumping assetic ...</msg>');
        $this->runCommand(
            'assetic:dump',
            [
                '--env' => 'prod',
            ],
            $this->output
        );
        $this->output->writeln('<msg>Clearing cache ...</msg>');
        $this->runCommand(
            'cache:clear',
            [],
            $this->output
        );
        $this->output->writeln('<msg>Generating entities ...</msg>');
        $this->runCommand(
            'generate:doctrine:entities',
            [
                'name'        => 'KTUDatabaseBundle',
                '--no-backup' => true,
            ],
            $this->output
        );
        $this->output->writeln('<msg>Updating database ...</msg>');
        $this->runCommand(
            'doctrine:schema:update',
            [
                '--force' => true,
            ],
            $this->output
        );
        $this->output->writeln(str_repeat('-', 59));
    }
} 