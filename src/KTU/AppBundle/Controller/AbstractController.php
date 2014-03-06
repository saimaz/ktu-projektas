<?php
namespace KTU\AppBundle\Controller;

use KTU\AppBundle\Traits\ModelTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    use ModelTrait;

    protected function getContainer()
    {
        return $this->container;
    }
} 