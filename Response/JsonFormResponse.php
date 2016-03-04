<?php

namespace MandarinMedien\MMCmfAdminBundle\Response;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonFormResponse extends JsonResponse
{

    public function __construct(Form $form, $status = 200, $headers = array())
    {
        parent::__construct(
            array(
                'success' => $form->isValid(),
                'data' => array(
                    'form' => $form->getName(),
                    'errors' => $this->getErrorMessages($form)
                )
            ),
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