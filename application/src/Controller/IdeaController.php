<?php

namespace App\Controller;

use App\Entity\Idea;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends AbstractController
{
    /**
     * @Route("/idea/list", name="idea_list")
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(Idea::class);

        $ideas = $repository->findAll();

        return $this->render('idea/index.html.twig', [
            'controller_name' => 'IdeaController',
            'ideas' => $ideas,
        ]);
    }
}
