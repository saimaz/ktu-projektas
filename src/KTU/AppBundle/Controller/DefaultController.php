<?php

namespace KTU\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KTUAppBundle:Default:index.html.twig');
    }
}
