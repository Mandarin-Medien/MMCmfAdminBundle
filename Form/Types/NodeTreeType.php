<?php

namespace MandarinMedien\MMCmfAdminBundle\Form\Types;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use MandarinMedien\MMCmfNodeBundle\Entity\NodeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MandarinMedien\MMCmfNodeBundle\Entity\Node;


class NodeTreeType extends AbstractType
{
    protected $class = 'MandarinMedien\MMCmfNodeBundle\Entity\Node';
    protected $manager;
    protected $parentNode = null;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * define a node as entry point for the node tree
     *
     * @param NodeInterface $node
     * @return NodeTreeType
     */
    public function setParentNode(NodeInterface $node = null)
    {
        $this->parentNode = $node;
        return $this;
    }

    /**
     * @return NodeInterface|null
     */
    protected function getParentNode()
    {
        return $this->parentNode;
    }


    /**
     * get first level nodes
     * @param $class
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRootNodes()
    {
        return $this->manager->getRepository($this->class)->findByParent(null);
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $view->vars['nodes'] = $this->getParentNode() ? array($this->getParentNode()) : $this->getRootNodes();
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $parent = $this->parentNode;

        $resolver->setDefaults(array(
            'class' => $this->class
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mm_cmf_admin_node_tree';
    }


    public function getParent()
    {
        return 'entity_hidden';
    }
}