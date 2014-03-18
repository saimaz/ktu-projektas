<?php
namespace KTU\AppBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractModel {
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /* @return \Symfony\Component\DependencyInjection\ContainerInterface */
    protected function getContainer()
    {
        return $this->container;
    }

    /* @return \Doctrine\Bundle\DoctrineBundle\Registry */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }
} 