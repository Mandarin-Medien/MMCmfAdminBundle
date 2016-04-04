<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfAdminBundle\Response\JsonFormResponse;
use MandarinMedien\MMCmfMenuBundle\Entity\Menu;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRouteInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MandarinMedien\MMCmfAdminBundle\Form\MenuType;
use MandarinMedien\MMCmfAdminBundle\Form\NodeRouteType;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Component\HttpFoundation\Request;

class CmfAdminNodeRouteController extends CmfAdminBaseController
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MMCmfRoutingBundle:NodeRoute')->findAll();

        return $this->render("MMCmfAdminBundle:Admin/NodeRoute:noderoute.list.html.twig", array(
            'noderoutes' => $entities,
            'factory' => $this->get('mm_cmf_routing.node_route_factory'),
            'types' => $this->get('mm_cmf_routing.node_route_factory')->getDiscriminators()
        ));
    }


    public function newAction($node_route_type)
    {

        $factory = $this->get('mm_cmf_routing.node_route_factory');

        $entity = $factory->createNodeRoute($node_route_type);
        if($entity){

            $form = $this->createCreateForm($entity);

            return $this->render('MMCmfAdminBundle:Admin/NodeRoute:noderoute.new.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ));
        }
    }


    public function createAction(Request $request, $node_route_type)
    {
        $factory = $this->get('mm_cmf_routing.node_route_factory');

        $entity = $factory->createNodeRoute($node_route_type);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }

        return $this->formResponse($form);
    }


    public function editAction(NodeRoute $nodeRoute)
    {
        return $this->render("@MMCmfAdmin/Admin/Menu/menu.edit.html.twig", array(
            'form' => $this->createEditForm($nodeRoute)->createView(),
            'nodeRoute' => $nodeRoute,
        ));
    }


    public function updateAction(NodeRoute $nodeRoute)
    {

        $form = $this->createEditForm($nodeRoute);
        $form->handleRequest($this->get('request'));

        //var_dump($this->get('request'));die();

        if($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('mm_cmf_admin_noderoute_edit', array(
            'id' => $nodeRoute->getId()
        ));
    }


    public function createEditForm(NodeRouteInterface $nodeRoute)
    {
        return $this->createForm(new NodeRouteType(), $nodeRoute, array(
            'method' => 'PUT',
            'attr' => array(
                'rel' => 'ajax'
            ),
            'action' => $this->generateUrl('mm_cmf_admin_noderoute_update', array(
                'id' => $nodeRoute->getId()
            ))
        ));
    }

    public function createCreateForm(NodeRouteInterface $nodeRoute)
    {
        return $this->createForm(new NodeRouteType(), $nodeRoute, array(
            'method' => 'POST',
            'action' => $this->generateUrl('mm_cmf_admin_noderoute_create', array(
                'node_route_type' => $this->get('mm_cmf_routing.node_route_factory')
                    ->getDiscriminatorByClass($nodeRoute)
            ))
        ));
    }


    public function deleteAction($id)
    {

        //if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MMCmfRoutingBundle:NodeRoute')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }


        $em->remove($entity);
        $em->flush();
        //}

        return $this->redirectToRoute('mm_cmf_admin_noderoute');
    }

}