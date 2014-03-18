<?php

namespace KTU\AdminBundle\Controller;

use KTU\AppBundle\Controller\AbstractController;
use KTU\AppBundle\Model\CronJobModel;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        return $this->render('KTUAdminBundle:Default:index.html.twig');
    }
}
