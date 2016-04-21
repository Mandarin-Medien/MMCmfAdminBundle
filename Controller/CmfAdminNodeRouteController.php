<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfAdminBundle\Form\Types\NodeRouteInlineType;
use MandarinMedien\MMCmfAdminBundle\Response\JsonFormResponse;
use MandarinMedien\MMCmfContentBundle\Entity\Page;
use MandarinMedien\MMCmfMenuBundle\Entity\Menu;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRouteInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MandarinMedien\MMCmfAdminBundle\Form\MenuType;
use MandarinMedien\MMCmfAdminBundle\Form\NodeRouteType;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CmfAdminNodeRouteController extends CmfAdminBaseController
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MMCmfRoutingBundle:NodeRoute')->findAll();

        return $this->renderAdmin("MMCmfAdminBundle:Admin/NodeRoute:noderoute.list.html.twig", array(
            'noderoutes' => $entities,
            'factory' => $this->get('mm_cmf_routing.node_route_factory'),
            'types' => $this->get('mm_cmf_routing.node_route_factory')->getDiscriminators()
        ));
    }


    public function newAction(Request $request, $node_route_type)
    {

        $page = null;

        if($page_id = (int) $request->get('page'))
        {
            $page = $this->getDoctrine()->getRepository('MMCmfContentBundle:Page')->find($page_id);
        }

        $factory = $this->get('mm_cmf_routing.node_route_factory');

        $entity = $factory->createNodeRoute($node_route_type);
        $entity->setNode($page);

        if ($entity) {

            $form = $this->createCreateForm($entity);

            return $this->renderAdmin('MMCmfAdminBundle:Admin/NodeRoute:noderoute.new.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ), 'Route erstellen', 'link');
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


    public function editAction($id)
    {

        $nodeRoute = $this->getDoctrine()->getRepository('MMCmfRoutingBundle:NodeRoute')->find($id);

        return $this->renderAdmin("@MMCmfAdmin/Admin/NodeRoute/noderoute.edit.html.twig", array(
            'form' => $this->createEditForm($nodeRoute)->createView(),
            'nodeRoute' => $nodeRoute,
        ), 'Route bearbeiten', 'link');
    }


    public function updateAction(NodeRoute $nodeRoute)
    {

        $form = $this->createEditForm($nodeRoute);
        $form->handleRequest($this->get('request'));

        //var_dump($this->get('request'));die();

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }


        return $this->formResponse($form);

        /*return $this->redirectToRoute('mm_cmf_admin_noderoute_edit', array(
            'id' => $nodeRoute->getId()
        ));*/
    }


    public function createEditForm(NodeRoute $nodeRoute)
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


    public function getInlineFormAction($node_route_type, Page $page)
    {

        $factory = $this->container->get('mm_cmf_routing.node_route_factory');
        $nodeRoute = $factory->createNodeRoute($node_route_type);

        $form = $this->createForm(NodeRouteInlineType::class, $nodeRoute);
        $parent = $this->createForm($this->container->get('mm_cmf_admin.page_type'), $page);


        return new JsonResponse(
            array(
                'content' => $this->renderView('@MMCmfAdmin/Admin/Page/page.route.html.twig', array(
                    'form' => $form->createView($parent->createView())
                ))
            )
        );
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