<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfAdminBundle\Form\PageType;
use MandarinMedien\MMCmfContentBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CmfAdminPageController extends CmfAdminBaseController
{


    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MMCmfContentBundle:Page')->findAll();

        return $this->render("MMCmfAdminBundle:Admin/Page:page.list.html.twig", array(
            'pages' => array_filter($entities, function($object) {
                return get_class($object) == 'MandarinMedien\MMCmfContentBundle\Entity\Page';
            })
        ));
    }


    public function newAction(Request $request)
    {
        $entity = new Page();
        $form   = $this->createCreateForm($entity);

        return $this->render('MMCmfAdminBundle:Admin/Page:page.new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));

    }


    public function createAction(Request $request)
    {
        $entity = new Page();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }

        return $this->formResponse($form);
    }


    private function createCreateForm(Page $entity)
    {
        $form = $this->createForm($this->container->get('mm_cmf_admin.page_type'), $entity, array(
            'action' => $this->generateUrl('mm_cmf_admin_page_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to edit an existing Page entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MMCmfContentBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('@MMCmfAdmin/Admin/Page/page.edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }



    private function createEditForm(Page $entity)
    {
        $form = $this->createForm($this->container->get('mm_cmf_admin.page_type'), $entity, array(
            'action' => $this->generateUrl('mm_cmf_admin_page_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr' => array(
                'rel' => 'ajax'
            )
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }


    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MMCmfContentBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }


        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
        }

        return $this->formResponse($editForm);
    }

    public function deleteAction(Request $request, $id)
    {


        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MMCmfContentBundle:Page')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Article entity.');
            }

            if($parent = $entity->getParent())
            {
                $parent->removeNode($entity);
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('mm_cmf_admin_page'));
    }



    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mm_cmf_admin_page_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }
}
