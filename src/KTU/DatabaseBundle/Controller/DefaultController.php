<?php

namespace KTU\DatabaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('KTUDatabaseBundle:Default:index.html.twig', array('name' => $name));
    }
}
