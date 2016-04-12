<?php

namespace MandarinMedien\MMCmfAdminBundle\Response;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonFormResponse extends JsonResponse
{

    public function __construct(Form $form, $status = 200, $headers = array())
    {

        $responseData =  array(
            'success' => $form->isValid(),
            'data' => array(
                'form' => $form->getName(),
                'errors' => $this->getErrorMessages($form)
            )
        );

        if($form->has('save_and_add') && $form->get('save_and_add')->isClicked()) {

            $redirect = $form->get('save_and_add')->getConfig()->getOption('attr')['data-target'];
            $responseData['data']['redirect'] = $redirect;
        }

        elseif($form->has('save_and_back') && $form->get('save_and_back')->isClicked()) {

            $redirect = $form->get('save_and_back')->getConfig()->getOption('attr')['data-target'];
            $responseData['data']['redirect'] = $redirect;
        }

        parent::__construct(
            $responseData,
            $status,
            $headers
        );
    }

    private function getErrorMessages(Form $form)
    {
        $errors = array();

        foreach ($form->getErrors(true, true) as $key => $error) {

            $template   = $error->getMessageTemplate();
            $parameters = $error->getMessageParameters();

            $errors[$error->getOrigin()->getName()] = strtr($template, $parameters);
        }


        return $errors;
    }
}