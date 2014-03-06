<?php
namespace KTU\AppBundle\Command;

use KTU\AppBundle\Traits\ModelTrait;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends ContainerAwareCommand
{
    use ModelTrait;

    /* @return \Doctrine\Bundle\DoctrineBundle\Registry */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    protected function runShell($command, OutputInterface $output)
    {
        $handle = popen($command . '  2>&1', 'r');
        while (!feof($handle)) {
            $line = fgets($handle);
            $output->write($line);
        }
        pclose($handle);
    }

    protected function runCommand($command, array $arguments, $output)
    {
        $command = $this->getApplication()->find($command);
        $input   = new ArrayInput(array_merge(['command' => $command], $arguments));
        $command->run($input, $output);
    }
} 