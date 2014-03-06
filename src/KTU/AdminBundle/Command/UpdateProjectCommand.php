<?php
namespace KTU\AdminBundle\Command;

use KTU\AppBundle\Command\AbstractCommand;
use KTU\AppBundle\Model\CronJobModel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateProjectCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('project:update')
            ->setDescription('Updates the project');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $job = $this->getCronJobModel()->getWaitingJob();

        if($job) {
            $job->setStatus(CronJobModel::STATUS_RUNNING);

            switch($job->getAction()) {
                case CronJobModel::ACTION_UPDATE:
                    exec('git pull');
            }

            $job->setStatus(CronJobModel::STATUS_DONE);
        }
    }
} 