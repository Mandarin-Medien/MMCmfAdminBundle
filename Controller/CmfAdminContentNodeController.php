<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfAdminBundle\Form\ContentNodeType;
use MandarinMedien\MMCmfContentBundle\Entity\ContentNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CmfAdminContentNodeController extends Controller
{


    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MMCmfContentBundle:ContentNode')->findAll();

        return $this->render("MMCmfAdminBundle:Admin/ContentNode:contentnode.list.html.twig", array(
            'contentnodes' => $entities,
            'factory' => $this->get('mm_cmf_content.content_node_factory')
        ));
    }


    public function newAction($contentnode_type)
    {
        $factory = $this->get('mm_cmf_content.content_node_factory');

        $entity = $factory->createContentNode($contentnode_type);
        $form   = $this->createCreateForm($entity);

        return $this->render('MMCmfAdminBundle:Admin/ContentNode:contentnode.new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    public function createAction(Request $request, $contentnode_type)
    {

        $factory = $this->get('mm_cmf_content.content_node_factory');

        $entity = $factory->createContentNode($contentnode_type);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mm_cmf_admin_contentnode'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    private function createCreateForm(ContentNode $entity)
    {
        $form = $this->createForm($this->get('mm_cmf_admin.form_type.content_node'), $entity, array(
            'action' => $this->generateUrl('mm_cmf_admin_contentnode_create', array(
                'contentnode_type' => $this->get('mm_cmf_content.content_node_factory')->getDiscrimatorByClass($entity)
            )),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to edit an existing ContentNode entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MMCmfContentBundle:ContentNode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContentNode entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('@MMCmfAdmin/Admin/ContentNode/backend/contentnode.edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }



    private function createEditForm(ContentNode $entity)
    {
        $form = $this->createForm($this->get('mm_cmf_admin.form_type.content_node'), $entity, array(
            'action' => $this->generateUrl('mm_cmf_admin_contentnode_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }


    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MMCmfContentBundle:ContentNode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContentNode entity.');
        }


        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mm_cmf_admin_contentnode_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        );
    }

    public function deleteAction(Request $request, $id)
    {


        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        //if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MMCmfContentBundle:ContentNode')->find($id);

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

        return $this->redirect($this->generateUrl('mm_cmf_admin_contentnode'));
    }


    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mm_cmf_admin_contentnode_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }
}
