<?php
namespace KTU\AdminBundle\Controller;

use KTU\AppBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DaemonController extends AbstractController
{
    public function listAction(Request $request)
    {
        $names           = $this->getDaemonModel()->getActionNames();
        $vars            = [];
        $vars['success'] = false;
        /*[
                'list' => $this->getDaemonModel()->getActionList(),
                'names' => $names,
                'register' => $form->createView()
            ]*/

        $form = $this->createFormBuilder()
            ->add(
                'action',
                'choice',
                [
                    'empty_value' => '---',
                    'choices'     => $names,
                ]
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $formData = $form->getData();

            $this->getDaemonModel()->registerAction($formData['action']);
            $this->getDoctrine()->getManager()->flush();
            $vars['success'] = true;
        }

        $vars['list']     = $this->getDaemonModel()->getActionList();
        $vars['names']    = $names;
        $vars['register'] = $form->createView();
        return $this->render('KTUAdminBundle:daemon:list.html.twig', $vars);
    }

    public function getListItemAction($id)
    {
        $action = $this->getDaemonModel()->getAction($id);
        $names  = $this->getDaemonModel()->getActionNames();

        if (!$action) {
            throw $this->createNotFoundException('Not found');
        }

        return $this->render(
            'KTUAdminBundle:daemon:list-item.html.twig',
            [
                'action' => $action,
                'names' => $names
            ]
        );
    }
} 