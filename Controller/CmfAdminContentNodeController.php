<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfAdminBundle\Response\JsonFormResponse;
use MandarinMedien\MMCmfAdminBundle\Form\ContentNodeType;
use MandarinMedien\MMCmfContentBundle\Entity\ContentNode;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CmfAdminContentNodeController extends CmfAdminBaseController
{


    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MMCmfContentBundle:ContentNode')->findAll();

        return $this->renderAdmin("MMCmfAdminBundle:Admin/ContentNode:contentnode.list.html.twig", array(
            'contentnodes' => $entities,
            'contentParser' => $this->get('mm_cmf_content.content_parser'),
            'contentNodeFactory' => $this->get('mm_cmf_content.content_node_factory')
        ));
    }


    public function newAction(Request $request, $contentnode_type)
    {
        $factory    = $this->get('mm_cmf_content.content_node_factory');
        $repository = $this->getDoctrine()->getRepository('MMCmfNodeBundle:Node');
        $contentParser = $this->container->get('mm_cmf_content.content_parser');

        $parent_node = null;
        $entity = $factory->createContentNode($contentnode_type);

        if((int) $request->get('parent_node')) {
            if($parent_node = $repository->find((int)$request->get('parent_node'))) {
                $entity->setParent($parent_node);
            }
        }

        $form   = $this->createCreateForm($entity, $parent_node);

        return $this->renderAdmin(
            '@MMCmfAdmin/Admin/ContentNode/contentnode.new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView()
            ),
            'Neue '.$contentnode_type,
            $contentParser->getIcon(get_class($entity))
        );
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
        }

        return $this->formResponse($form);
    }



    private function createCreateForm(ContentNode $entity)
    {

        $contentNodeFactory = $this->get('mm_cmf_content.content_node_factory');

        $form = $this->createForm(
            $this->get('mm_cmf_content.form_type.content_node'),
            $entity,
            array(
                'root_node' => $entity->getParent(),
                'action' => $this->generateUrl('mm_cmf_admin_contentnode_create',
                    array('contentnode_type' => $this->get('mm_cmf_content.content_node_factory')->getDiscriminatorByClass($entity)
                )),
                'method' => 'POST',
            )
        );

        $form
            ->add('submit', 'submit', array('label' => 'save'))
            ->add('save_and_add', 'submit', array(
                'attr' => array(
                    'data-target' => $this->container->get('router')->generate('mm_cmf_admin_contentnode_new', array(
                        'discriminator' => $contentNodeFactory->getDiscriminatorByClass($entity)
                    ))
                ),
            ))
            ->add('save_and_back', 'submit', array(
                'attr' => array(
                    'data-target' => $this->container->get('router')->generate('mm_cmf_admin_noderoute')
                )
            ));

        return $form;
    }


    /**
     * Displays a form to edit an existing ContentNode entity.
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MMCmfContentBundle:ContentNode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContentNode entity.');
        }

        $form = $this->createEditForm($entity);

        return $this->renderAdmin('@MMCmfAdmin/Admin/ContentNode/contentnode.edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $form->createView(),
        ));
    }



    private function createEditForm(ContentNode $entity)
    {

        $contentNodeFactory = $this->get('mm_cmf_content.content_node_factory');

        $form = $this->createForm($this->get('mm_cmf_content.form_type.content_node'), $entity, array(
            'action' => $this->generateUrl('mm_cmf_admin_contentnode_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr' => array(
                'rel' => 'ajax'
            )
        ));

        $form
            ->add('submit', 'submit', array('label' => 'save'))
            ->add('save_and_add', 'submit', array(
                'attr' => array(
                    'data-target' => $this->container->get('router')->generate('mm_cmf_admin_contentnode_new', array(
                        'discriminator' => $contentNodeFactory->getDiscriminatorByClass($entity)
                    ))
                ),
            ))
            ->add('save_and_back', 'submit', array(
                'attr' => array(
                    'data-target' => $this->container->get('router')->generate('mm_cmf_admin_noderoute')
                )
            ));

        return $form;
    }


    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MMCmfContentBundle:ContentNode')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContentNode entity.');
        }

        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
        }

       return $this->formResponse($form);

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
