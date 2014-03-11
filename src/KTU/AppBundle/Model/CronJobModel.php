<?php
namespace KTU\AppBundle\Model;

use KTU\DatabaseBundle\Entity\CronJob;

class CronJobModel extends AbstractModel
{
    const ACTION_UPDATE = 'update';

    const STATUS_WAITING = 'waiting';
    const STATUS_RUNNING = 'running';
    const STATUS_DONE = 'done';

    public function addJob($action)
    {
        $job = new CronJob();
        $job->setAction($action);
        $job->setStatus(self::STATUS_WAITING);
        $job->setRegistered(new \DateTime());

        $this->getDoctrine()->getManager()->persist($job);
        $this->getDoctrine()->getManager()->flush();
    }

    /* @return \KTU\DatabaseBundle\Entity\CronJob */
    public function getWaitingJob()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('KTUDatabaseBundle:CronJob')->findOneBy([
                'status' => self::STATUS_WAITING,
            ]);
    }

    public function setStatus(CronJob $job, $status)
    {
        $job->setStatus($status);
        $this->getDoctrine()->getManager()->flush();
    }

    public function run(CronJob $job)
    {
        $job->setStatus(self::STATUS_RUNNING);
        $this->getDoctrine()->getManager()->flush();
    }

    public function end(CronJob $job)
    {
        $job->setStatus(self::STATUS_DONE);
        $job->setExecuted(new \DateTime());
        $this->getDoctrine()->getManager()->flush();
    }

    public function getAll()
    {
        return $this->getDoctrine()->getRepository('KTUDatabaseBundle:CronJob')->findAll();
    }
} 