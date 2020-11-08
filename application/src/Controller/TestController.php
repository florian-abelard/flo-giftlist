<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/back/test")
     *
     * @return Response
     */
    public function test()
    {
        echo '<pre>', print_r('TEST CONTROLLER', 1), '</pre>';
    }
}
