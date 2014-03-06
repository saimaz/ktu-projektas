<?php
namespace KTU\AppBundle\Traits;

/* @method \Symfony\Component\DependencyInjection\ContainerInterface getContainer() */
trait ModelTrait {
    /* @return \KTU\AppBundle\Model\UserModel */
    protected function getUserModel()
    {
        return $this->getContainer()->get('model.user');
    }

    /* @return \KTU\AppBundle\Model\CronJobModel */
    protected function getCronJobModel()
    {
        return $this->getContainer()->get('model.cronjob');
    }
} 