<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfMenuBundle\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MandarinMedien\MMCmfAdminBundle\Form\MenuType;
use Symfony\Component\HttpFoundation\Request;

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


    public function newAction()
    {
        $entity = new Menu();
        $form   = $this->createCreateForm($entity);

        return $this->render('MMCmfAdminBundle:Admin/Menu:menu.new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function createAction(Request $request)
    {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mm_cmf_admin_menu'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    public function editAction(Menu $menu)
    {
        return $this->render("@MMCmfAdmin/Admin/Menu/menu.edit.html.twig", array(
            'form' => $this->createEditForm($menu)->createView(),
            'menu' => $menu
        ));
    }


    public function updateAction(Menu $menu)
    {

        $form = $this->createEditForm($menu);
        $form->handleRequest($this->get('request'));

        //var_dump($this->get('request'));die();

        if($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('mm_cmf_admin_menu_edit', array(
            'id' => $menu->getId()
        ));
    }


    public function createEditForm(Menu $menu)
    {
        return $this->createForm(new MenuType(), $menu, array(
            'method' => 'PUT',
            'action' => $this->generateUrl('mm_cmf_admin_menu_update', array(
                'id' => $menu->getId()
            ))
        ));
    }

    public function createCreateForm(Menu $menu)
    {
        return $this->createForm(new MenuType(), $menu, array(
            'method' => 'POST',
            'action' => $this->generateUrl('mm_cmf_admin_menu_create', array(
                'id' => $menu->getId()
            ))
        ));
    }


    public function deleteAction($id)
    {

        //if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MMCmfMenuBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        if($parent = $entity->getParent())
        {
            $parent->removeItem($entity);
        }

        $em->remove($entity);
        $em->flush();
        //}

        return $this->redirectToRoute('mm_cmf_admin_menu');
    }

}