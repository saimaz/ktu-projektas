<?php
namespace KTU\AppBundle\Command;

use KTU\AppBundle\Traits\ModelTrait;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends ContainerAwareCommand
{
    use ModelTrait;

    /* @return \Doctrine\Bundle\DoctrineBundle\Registry */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /* @return \Symfony\Component\Console\Helper\DialogHelper */
    protected function getDialog()
    {
        return $this->getHelperSet()->get('dialog');
    }
} 