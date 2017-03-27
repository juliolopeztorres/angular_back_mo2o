<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    protected function createApiResponse($data, $statusCode = 200)
    {
        $json = $this->serialize($data);

        return new Response($json, $statusCode, array(
            'Content-Type' => 'application/json'
        ));
    }

    protected function serialize($data, $format = 'json')
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->get('jms_serializer')
            ->serialize($data, $format, $context);
    }
}