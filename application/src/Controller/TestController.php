<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Entity\ValueObject\Price;
use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/back/test")
     * @return Response
     */
    public function test()
    {
        echo '<pre>', print_r('TEST CONTROLLER', 1), '</pre>';

        $entityManager = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository(Idea::class);

        $idea = $repository->find('211f18e1-6aca-4de7-9284-284bc449cefd');

        echo '<pre>',print_r($idea->getPrice()->value(), 1),'</pre>';

        $idea->setPrice(new Price($idea->getPrice()->value() + 1));

        $entityManager->persist($idea);

        $entityManager->flush();

        echo '<pre>', Debug::dump($idea), '</pre>';

        die('<pre>'. print_r($idea->getPrice()->value(), 1));

    }
}
