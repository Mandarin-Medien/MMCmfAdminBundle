<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use AppBundle\Entity\ParagraphNode;
use MandarinMedien\MMCmfContentBundle\Entity\ParagraphContentNode;
use MandarinMedien\MMCmfContentBundle\Entity\RowContentNode;
use MandarinMedien\MMCmfContentBundle\Form\FormTypeMetaReader;
use MandarinMedien\MMCmfMenuBundle\Entity\Menu;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MandarinMedien\MMCmfContentBundle\Entity\ContentNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CmfAdminController extends Controller
{

    public function dashboardAction()
    {
        $widgetManager = $this->get('mm_cmf_admin.widget_manager');

        return $this->render('@MMCmfAdmin/Admin/dashboard.html.twig', array(
            'widgets' => $widgetManager->getWidgets('dashboard')
        ));
    }


    public function liveEditAction(NodeRoute $route = null)
    {

        if($route == null) {
            $nodeRoutes = $this->getDoctrine()->getRepository('MMCmfRoutingBundle:NodeRoute')->findAll();
            if(count($nodeRoutes) > 0) {
                $route = $nodeRoutes[0];
            }
        }

        if($route == null) {
            $path = $this->get('router')->generate('mm_cmf_admin_homepage_empty');
        } else {
            $path = $this->get('router')->generate('mm_cmf_node_route', array(
                'route' => $route
            ));
        }

        return $this->render('MMCmfAdminBundle:Admin/LiveEdit:default.html.twig', array(
            'iframe_path' => $path,
            'factory' => $this->get('mm_cmf_content.content_node_factory'),
            'contentParser' => $this->get('mm_cmf_content.content_parser'),
            'node' => $route->getNode(),
            'menus' => array_filter($this->getDoctrine()->getRepository('MMCmfMenuBundle:Menu')->findAll(), function($menu)
            {
                return get_class($menu) == 'MandarinMedien\MMCmfMenuBundle\Entity\Menu';
            })
        ));
    }


    public function emptyAction()
    {
        return $this->render('@MMCmfAdmin/Admin/page.empty.html.twig');
    }

    public function toggleVisibilityAction(Node $entity, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $entity->setVisible($entity->isVisible() ? false : true);
        $manager->flush();

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }


    public function nodeAdminTestAction()
    {
        return $this->render('@MMCmfAdmin/Admin/ContentNode/content.node.edit.html.twig', array(
            'form' => $this->createForm($this->get('mm_cmf_content.form_type.content_node'), new ParagraphContentNode())->createView()
        ));
    }
}
