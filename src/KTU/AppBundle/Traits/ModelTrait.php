<?php
namespace KTU\AppBundle\Traits;

/* @method \Symfony\Component\DependencyInjection\ContainerInterface getContainer() */
trait ModelTrait
{
    /* @return \KTU\AppBundle\Model\UserModel */
    protected function getUserModel()
    {
        return $this->getContainer()->get('app_bundle.user.model');
    }

    /* @return \KTU\DaemonBundle\Model\DaemonModel */
    protected function getDaemonModel()
    {
        return $this->getContainer()->get('daemon.model');
    }

}