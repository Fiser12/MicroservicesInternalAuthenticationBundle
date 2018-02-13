<?php

namespace Fiser\MicroservicesInternalAuthenticationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MicroservicesInternalAuthenticationBundle:Default:index.html.twig');
    }
}
