<?php

namespace MandarinMedien\MMCmfAdminBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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

        $builder
            ->add('visible')
            ->add('name')
            ->add('title')
            ->add('parent', 'entity', array(
                'class' => 'MandarinMedien\MMCmfContentBundle\Entity\Page',
                'required' => false,
                'query_builder' => function(EntityRepository $repository) {
                    return $repository->createQueryBuilder('p')
                       ;
                }
            ))
            //->add('routes', 'collection')
            ->add('keywords')
            ->add('description')
            ->add('robots')
            ->add('author')
            ->add('template', $this->container->get('mm_cmf_content.form_type.node_template')->setClass('MandarinMedien\MMCmfContentBundle\Entity\Page'))
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
