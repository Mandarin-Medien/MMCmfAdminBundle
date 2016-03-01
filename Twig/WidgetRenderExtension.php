<?php

namespace MandarinMedien\MMCmfAdminBundle\Twig;

use MandarinMedien\MMCmfAdminBundle\Admin\Widget\WidgetInterface;
use Symfony\Component\DependencyInjection\Container;

class WidgetRenderExtension extends \Twig_Extension
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('renderWidget', array($this, "renderWidgetFunction"), array(
                'is_safe' => array('html'),
                'needs_environment' => true
            ))
        );
    }

    /**
     * renders the menu
     *
     * @param \Twig_Environment $twig
     * @param WidgetInterface $widget
     * @param array $options
     * @return string
     */
    public function renderWidgetFunction(\Twig_Environment $twig, WidgetInterface $widget, array $options=array())
    {
        $template = $widget->getName();
        return $twig->render('MMCmfAdminBundle:Widget:'.$template.'.html.twig', array('widget' => $widget, 'options' => $options));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mm_cmf_admin_widget_extension';
    }
}