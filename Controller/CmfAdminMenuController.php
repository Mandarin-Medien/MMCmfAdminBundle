<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfMenuBundle\Entity\Menu;
use MandarinMedien\MMCmfAdminBundle\Form\MenuType;
use Symfony\Component\HttpFoundation\Request;

class CmfAdminMenuController extends CmfAdminBaseController
{

    /**
     * Menu List Action
     * gets list of all menus
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MMCmfMenuBundle:Menu')->findAll();

        return $this->renderAdmin("MMCmfAdminBundle:Admin/Menu:menu.list.html.twig", array(
            'menues' => array_filter($entities, function ($object) {
                return get_class($object) == 'MandarinMedien\MMCmfMenuBundle\Entity\Menu';
            }),
        ));
    }


    /**
     * Menu New Action
     * gets an form for creating new menu
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);

        return $this->renderAdmin('MMCmfAdminBundle:Admin/Menu:menu.new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }


    /**
     * create Action
     * handles the new form request
     *
     * @param Request $request
     * @return \MandarinMedien\MMCmfAdminBundle\Response\JsonFormResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request)
    {
        $entity = new Menu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }

        return $this->formResponse($form);
    }


    /**
     * edit action
     * get the form for editing an existing menu
     *
     * @param Menu $menu
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Menu $menu)
    {
        return $this->renderAdmin("@MMCmfAdmin/Admin/Menu/menu.edit.html.twig", array(
            'form' => $this->createEditForm($menu)->createView(),
            'menu' => $menu
        ), $menu->getName() . ' bearbeiten', 'sitemap');
    }


    /**
     * update action
     * handles the edit form request
     *
     * @param Menu $menu
     * @return \MandarinMedien\MMCmfAdminBundle\Response\JsonFormResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Menu $menu)
    {

        $form = $this->createEditForm($menu);
        $form->handleRequest($this->get('request_stack')->getCurrentRequest());

        //var_dump($this->get('request'));die();

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->formResponse($form);

        /*return $this->redirectToRoute('mm_cmf_admin_menu_edit', array(
            'id' => $menu->getId()
        ));*/
    }


    /**
     * create the edit form
     * @param Menu $menu
     * @return \Symfony\Component\Form\Form
     */
    public function createEditForm(Menu $menu)
    {
        return $this->createForm(MenuType::class, $menu, array(
            'method' => 'PUT',
            'attr' => array(
                'rel' => 'ajax'
            ),
            'action' => $this->generateUrl('mm_cmf_admin_menu_update', array(
                'id' => $menu->getId()
            ))
        ));
    }


    /**
     * create the new form
     *
     * @param Menu $menu
     * @return \Symfony\Component\Form\Form
     */
    public function createCreateForm(Menu $menu)
    {
        return $this->createForm(MenuType::class, $menu, array(
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

        if ($parent = $entity->getParent()) {
            $parent->removeItem($entity);
        }

        $em->remove($entity);
        $em->flush();
        //}

        return $this->redirectToRoute('mm_cmf_admin_menu');
    }

}