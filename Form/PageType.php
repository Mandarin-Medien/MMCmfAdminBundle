<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use MandarinMedien\MMCmfAdminBundle\Form\Types\NodeRouteInlineType;
use MandarinMedien\MMCmfContentBundle\Form\Type\TemplatableNodeTemplateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Router;
use MandarinMedien\MMCmfAdminBundle\Form\NodeRouteType;
use MandarinMedien\MMCmfContentBundle\Entity\Page;

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
            ->add('parent', EntityType::class, array(
                'class' => Page::class,
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
            ->add('template', TemplatableNodeTemplateType::class, array('className' => $class ))

            ->add('submit', SubmitType::class, array('label' => 'save'))
            ->add('save_and_add', SubmitType::class, array(
                'attr' => array(
                    'data-target' => $router->generate('mm_cmf_admin_page_new')
                )
            ))
            ->add('save_and_back', SubmitType::class, array(
                'attr' => array(
                    'data-target' => $router->generate('mm_cmf_admin_page')
                )
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Page::class
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'mm_cmf_admin_page';
    }
}
