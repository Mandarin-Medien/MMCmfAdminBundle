<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfMenuBundle\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use MandarinMedien\MMCmfAdminBundle\Form\MenuType;

class CmfAdminMenuController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MMCmfMenuBundle:Menu')->findAll();

        return $this->render("MMCmfAdminBundle:Admin/Menu:menu.list.html.twig", array(
            'menues' => array_filter($entities, function($object) {
                return get_class($object) == 'MandarinMedien\MMCmfMenuBundle\Entity\Menu';
            })
        ));
    }


    public function editAction(Menu $menu)
    {
        return $this->render("@MMCmfAdmin/Admin/Menu/menu.edit.html.twig", array(
            'form' => $this->createForm(new MenuType(), $menu)->createView(),
            'menu' => $menu
        ));
    }


    public function deleteAction()
    {
        return $this->redirectToRoute('mm_cmf_admin_menu');
    }

}