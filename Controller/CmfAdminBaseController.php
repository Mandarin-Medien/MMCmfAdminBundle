<?php

namespace MandarinMedien\MMCmfAdminBundle\Controller;

use MandarinMedien\MMCmfAdminBundle\Response\AdminXHRResponse;
use MandarinMedien\MMCmfAdminBundle\Response\JsonFormResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CmfAdminBaseController extends Controller
{

    public function renderAdmin($view, array $parameters = array(), $title = 'Node beabeiten', $icon = 'edit')
    {

        $request    = $this->get('request');
        $twig       = $this->get('twig');
        $translator = $this->get('translator');

        $parameters['extends_from'] = 'MMCmfAdminBundle:Admin:admin.html.twig';

        if($request->isXmlHttpRequest()) {
            $parameters['extends_from'] = 'MMCmfAdminBundle:Admin:admin.xhr.html.twig';
            $content = $twig->render($view, $parameters);
            $response = new AdminXHRResponse(
                $content,
                200,
                array(),
                $translator->trans($title),
                $icon
            );
        }

        else {
            $response = parent::render($view, $parameters);
        }

        return $response;

    }


    /**
     * default response for Form Actions
     * returns either JsonFormResponse on XHR Request or RedirectResponse
     *
     * @param Form $form the handled form
     * @return JsonFormResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function formResponse(Form $form)
    {
        $request = $this->get('request');

        if ($request->isXmlHttpRequest()) {
            return new JsonFormResponse($form);
        } else {

            if ($form->has('save_and_add') && $form->get('save_and_add')->isClicked()) {
                $redirect = $form->get('save_and_add')->getConfig()->getOption('attr')['data-target'];
            } elseif ($form->has('save_and_back') && $form->get('save_and_back')->isClicked()) {
                $redirect = $form->get('save_and_back')->getConfig()->getOption('attr')['data-target'];
            } else {
                $redirect = $request->headers->get('referer');
            }

            return $this->redirect($redirect);
        }
    }
}