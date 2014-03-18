<?php
namespace KTU\DaemonBundle\Action;

use KTU\DatabaseBundle\Entity\DaemonAction;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractAction {
    protected $container;
    protected $action;

    abstract public function run();

    public function __construct(ContainerInterface $container, DaemonAction $action)
    {
        $this->container = $container;
        $this->action = $action;
    }

    protected function getContainer()
    {
        return $this->container;
    }

    protected function log($message)
    {
        $this->getContainer()->get('daemon.model')->log($this->action, $message);
    }
}