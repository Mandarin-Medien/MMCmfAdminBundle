<?php

namespace MandarinMedien\MMCmfAdminBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class AdminXHRResponse extends JsonResponse
{
    public function __construct($content, $status = 200, array $headers = array(), $title = 'Node bearbeiten', $icon = 'edit')
    {

        $data = array(
            'success' => true,
            'data' => array(
                'icon' => $icon,
                'name' => $title,
                'content' => $content
            )
        );

        parent::__construct($data, $status, $headers);
    }

}