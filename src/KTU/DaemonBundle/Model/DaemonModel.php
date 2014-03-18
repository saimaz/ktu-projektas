<?php
namespace KTU\DaemonBundle\Model;

use KTU\DatabaseBundle\Entity\DaemonAction;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DaemonModel {
    protected $container;

    const STATUS_WAITING = 'waiting';
    const STATUS_RUNNING = 'running';
    const STATUS_DONE = 'done';

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

    public function registerAction($action)
    {
        $actions = $this->getActions();

        if(!in_array($action, array_keys($actions))) {
            throw new \InvalidArgumentException('Action \'' . $action . '\' is not registered');
        }

        $daemon = new DaemonAction();
        $daemon->setAction($action);
        $daemon->setStatus(self::STATUS_WAITING);
        $daemon->setRegistered(new \DateTime());

        $this->getDoctrine()->getManager()->persist($daemon);
    }

    public function run(DaemonAction $action)
    {
        $action->setStatus(self::STATUS_RUNNING);
        $this->getDoctrine()->getManager()->flush();
    }

    public function close(DaemonAction $action)
    {
        $action->setStatus(self::STATUS_DONE);
        $action->setExecuted(new \DateTime());
        $this->getDoctrine()->getManager()->flush();
    }

    public function getActions()
    {
        return $this->getContainer()->getParameter('daemon_actions');
    }

    public function getNewAction()
    {
        return $this->getDoctrine()->getRepository('KTUDatabaseBundle:DaemonAction')->findOneBy([
                'status' => self::STATUS_WAITING
            ]);
    }

    public function getActionList()
    {
        /* @var $manager \Doctrine\ORM\EntityManager */
        $manager = $this->getDoctrine()->getManager();
        $dql = 'SELECT a FROM KTUDatabaseBundle:DaemonAction a ORDER BY a.registered DESC';
        $query = $manager->createQuery($dql);
        $query->setMaxResults(10);

        return $query->getResult();
    }

    public function getActionNames()
    {
        $actions = $this->getContainer()->getParameter('daemon_actions');
        $result = [];

        foreach($actions as $action => $data) {
            $result[$action] = $data['name'];
        }

        return $result;
    }

    public function getAction($id)
    {
        return $this->getDoctrine()->getRepository('KTUDatabaseBundle:DaemonAction')->find($id);
    }

    public function log(DaemonAction $action, $message) {
        $action->setLog($action->getLog() . $message . PHP_EOL);
        $this->getDoctrine()->getManager()->flush();
    }
} 