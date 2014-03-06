<?php
namespace KTU\AppBundle\Model;

use Doctrine\Bundle\DoctrineBundle\Registry;

abstract class AbstractModel {
    protected $doctrine;

    public function setDoctrine(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /* @return \Doctrine\Bundle\DoctrineBundle\Registry */
    protected function getDoctrine()
    {
        return $this->doctrine;
    }
} 