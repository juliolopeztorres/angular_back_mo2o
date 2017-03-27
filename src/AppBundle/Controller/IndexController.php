<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    /**
     * @Route("/login")
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function loginAction()
    {
        return new Response('Login');
    }

}