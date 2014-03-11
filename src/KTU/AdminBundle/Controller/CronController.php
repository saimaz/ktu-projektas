<?php

namespace KTU\AdminBundle\Controller;

use KTU\AdminBundle\Form\Type\CronJobType;
use KTU\AppBundle\Controller\AbstractController;
use KTU\AppBundle\Model\CronJobModel;
use Symfony\Component\HttpFoundation\Request;

class CronController extends AbstractController
{
    public function listAction()
    {
        $vars = [];

        $jobs = $this->getCronJobModel()->getAll();
        $update = $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_update_project'))
            ->add('submit', 'submit')
            ->getForm();
        $form = $this->createForm(new CronJobType($jobs));



        $vars['jobs'] = $jobs;
        $vars['update'] = $update->createView();
        $vars['form'] = $form->createView();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            dd($_POST);
        }

        return $this->render('KTUAdminBundle:Cron:list.html.twig', $vars);
    }

    public function updateAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_update_project'))
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            $this->getCronJobModel()->addJob(CronJobModel::ACTION_UPDATE);
        }
        return $this->redirect($this->generateUrl('admin_cron'));
    }

}
