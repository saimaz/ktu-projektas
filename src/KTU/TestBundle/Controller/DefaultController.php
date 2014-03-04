<?php

namespace KTU\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('KTUTestBundle:Default:index.html.twig');
    }
}
