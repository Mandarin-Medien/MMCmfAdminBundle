<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use AppBundle\Entity\ParagraphNode;
use MandarinMedien\MMCmfContentBundle\Entity\ParagraphContentNode;
use MandarinMedien\MMCmfContentBundle\Entity\RowContentNode;
use MandarinMedien\MMCmfMenuBundle\Entity\Menu;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;

class CmfAdminController extends Controller
{
    public function indexAction(NodeRoute $route = null)
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

        return $this->render('MMCmfAdminBundle:Admin:pageedit.html.twig', array(
            'iframe_path' => $path
        ));
    }


    public function emptyAction()
    {
        return $this->render('@MMCmfAdmin/Admin/page.empty.html.twig');
    }


    public function nodeAdminTestAction()
    {
        return $this->render('@MMCmfAdmin/Admin/ContentNode/content.node.edit.html.twig', array(
            'form' => $this->createForm($this->get('mm_cmf_admin.form_type.content_node'), new ParagraphContentNode())->createView()
        ));
    }


    public function renderSidebarAction()
    {
        return $this->render('MMCmfAdminBundle:Admin:sidebar.html.twig', array(
            'widgets' => $this->get('mm_cmf_admin.widget_manager')->getWidgets('sidebar')
        ));
    }
}
