<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfMenuBundle\Entity\Menu;
use MandarinMedien\MMCmfRoutingBundle\Entity\NodeRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;

class CmfAdminController extends Controller
{
    public function indexAction(NodeRoute $route)
    {
        return $this->render('MMCmfAdminBundle:Admin:pageedit.html.twig', array(
            'iframe_path' => $this->get('router')->generate('mm_cmf_node_route', array(
                'route' => $route
                )
            )
        ));
    }


    public function menuAction()
    {
        $menues = $this->getDoctrine()->getRepository('MMCmfMenuBundle:Menu')->findAll();

        return $this->render("MMCmfAdminBundle:Admin/Menu:menu.list.html.twig", array(
            'menues' => array_filter($menues, function($object) {
              return get_class($object) == 'MandarinMedien\MMCmfMenuBundle\Entity\Menu';
            })
        ));
    }

    public function pageAction()
    {

    }


    public function menuEditAction(Menu $menu)
    {
        return $this->render("MMCmfAdminBundle:Admin/Menu:menu.edit.html.twig", array(
            'menu' => $menu
        ));
    }


    public function renderSidebarAction()
    {
        return $this->render('MMCmfAdminBundle:Admin:sidebar.html.twig', array(
            'items' => $this->get('mm_cmf_admin.admin_sidebar')->getWidgets()
        ));
    }
}
