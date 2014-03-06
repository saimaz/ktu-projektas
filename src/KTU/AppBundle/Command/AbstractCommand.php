<?php
namespace KTU\AppBundle\Command;

use KTU\AppBundle\Traits\ModelTrait;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class AbstractCommand extends ContainerAwareCommand
{
    use ModelTrait;

    /* @return \Doctrine\Bundle\DoctrineBundle\Registry */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }
} 