<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MandarinMedien\MMCmfAdminBundle\Entity\User;
use MandarinMedien\MMCmfAdminBundle\Form\UserType;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User controller.
 *
 */
class CmfAdminUserController extends CmfAdminBaseController
{

    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MMCmfAdminBundle:User')->findAll();

        return $this->renderAdmin(
            'MMCmfAdminBundle:Admin/User:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }
    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {

        $userManager = $this->get('fos_user.user_manager');

        $entity = $userManager->createUser();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateCanonicalFields($entity);
            $userManager->updatePassword($entity);
            $userManager->updateUser($entity);
        }


        return $this->formResponse($form);
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserInterface $entity)
    {
        $router = $this->get('router');

        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('mm_cmf_admin_user_create'),
            'method' => 'POST',
            'attr' => array(
                'rel' => 'ajax'
            )
        ));

        $form
            ->add('submit', 'submit', array('label' => 'save'))
            ->add('save_and_add', 'submit', array(
                'attr' => array(
                    'data-target' => $router->generate('mm_cmf_admin_user_new')
                ),
            ))
            ->add('save_and_back', 'submit', array(
                'attr' => array(
                    'data-target' => $router->generate('mm_cmf_admin_user')
                )
            ));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

        return $this->renderAdmin('MMCmfAdminBundle:Admin/User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MMCmfAdminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->renderAdmin('MMCmfAdminBundle:Admin/User:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $id));

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User.');
        }

        $form = $this->createEditForm($user);
        $deleteForm = $this->createDeleteForm($id);

        return $this->renderAdmin('MMCmfAdminBundle:Admin/User:edit.html.twig', array(
            'entity'      => $user,
            'form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UserInterface $entity)
    {

        $router = $this->get('router');

        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('mm_cmf_admin_user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form
            ->add('submit', 'submit', array('label' => 'save'))
            ->add('save_and_add', 'submit', array(
                'attr' => array(
                    'data-target' => $router->generate('mm_cmf_admin_user_new')
                ),
            ))
            ->add('save_and_back', 'submit', array(
                'attr' => array(
                    'data-target' => $router->generate('mm_cmf_admin_user')
                )
            ));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $id));


        if (!$user) {
            throw $this->createNotFoundException('Unable to find User.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($user);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $userManager->updateUser($user);
            return $this->redirect($this->generateUrl('mm_cmf_admin_user_edit', array('id' => $id)));
        }


        return $this->formResponse($editForm);


        /*return $this->render('MMCmfAdminBundle:Admin/User:edit.html.twig', array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));*/
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MMCmfAdminBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->formResponse($form);

        //return $this->redirect($this->generateUrl('mm_cmf_admin_user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mm_cmf_admin_user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    /**
     * toogles the enabled field of the given user
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $id));

        if($user->isEnabled()) {
            $user->setEnabled(false);
        } else {
            $user->setEnabled(true);
        }

        $userManager->updateUser($user);

        return $this->redirect($this->generateUrl('mm_cmf_admin_user'));
    }
}
