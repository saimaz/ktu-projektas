<?php

namespace KTU\AdminBundle\Controller;

use KTU\AppBundle\Controller\AbstractController;
use KTU\AppBundle\Model\CronJobModel;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('update', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            $this->getCronJobModel()->addJob(CronJobModel::ACTION_UPDATE);
        }

        return $this->render(
            'KTUAdminBundle:Default:index.html.twig',
            [
                'update' => $form->createView(),
            ]
        );
    }
}
