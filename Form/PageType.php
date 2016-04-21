<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use MandarinMedien\MMCmfAdminBundle\Form\Types\NodeRouteInlineType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\Router;
use MandarinMedien\MMCmfAdminBundle\Form\NodeRouteType;

class PageType extends AbstractType
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // get class of the current entity for template selection
        $class = get_class($options['data']);

        /**
         * @var Router $router
         */
        $router = $this->container->get('router');


        $builder
            ->add('name')
            ->add('metaTitle')
            ->add('parent', 'entity', array(
                'class' => 'MandarinMedien\MMCmfContentBundle\Entity\Page',
                'required' => false,
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('p')
                       ;
                }
            ))
            //->add('routes', 'collection')
            ->add('metaKeywords')
            ->add('metaDescription')
            ->add('metaRobots')
            ->add('metaAuthor')
            ->add('metaImage')
            ->add('visible')
            ->add('template', $this->container->get('mm_cmf_content.form_type.node_template')->setClass($class))

            ->add('submit', 'submit', array('label' => 'save'))
            ->add('save_and_add', 'submit', array(
                'attr' => array(
                    'data-target' => $router->generate('mm_cmf_admin_page_new')
                )
            ))
            ->add('save_and_back', 'submit', array(
                'attr' => array(
                    'data-target' => $router->generate('mm_cmf_admin_page')
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MandarinMedien\MMCmfContentBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mm_cmf_admin_page';
    }
}
