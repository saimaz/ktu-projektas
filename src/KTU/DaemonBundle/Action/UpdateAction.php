<?php
namespace KTU\DaemonBundle\Action;

use Symfony\Component\Process\Process;

class UpdateAction extends AbstractAction
{
    public function run()
    {
        /* @var $kernel \AppKernel */
        $kernel = $this->getContainer()->get('kernel');
        $logFile = $kernel->getRootDir() . '/logs/update.log';
        $env = $kernel->getEnvironment();
        $now = new \DateTime();
        $git = new Process('git pull');
        $assets = new Process('app/console assets:install web/ --env=' . $env);
        $assetic = new Process('app/console assetic:dump --env=' . $env);
        $cache = new Process('app/console cache:clear --env=' . $env);
        $entities = new Process('app/console generate:doctrine:entities KTUDatabaseBundle --no-backup');
        $database = new Process('app/console doctrine:schema:update --force');

        $git->run();
        $cache->run();
        $assets->run();
        $assetic->run();
        $entities->run();
        $database->run();

        $this->log('--( Update: ' . $now->format('Y-m-d H:i:s') . ' )--');
        $this->log($git->getOutput());
        $this->log($cache->getOutput());
        $this->log($assets->getOutput());
        $this->log($assetic->getOutput());
        $this->log($entities->getOutput());
        $this->log($database->getOutput());
        $this->log(str_repeat('-', 50));
    }
}