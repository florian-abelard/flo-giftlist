<?php

namespace App\Controller;

use App\Entity\GiftIdea;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GiftIdeaController extends AbstractController
{
    /**
     * @Route("/idea/list", name="gift_idea_list")
     */
    public function list()
    {
        $repository = $this->getDoctrine()->getRepository(GiftIdea::class);

        $ideas = $repository->findAll();

        return $this->render('gift_idea/index.html.twig', [
            'controller_name' => 'GiftIdeaController',
            'ideas' => $ideas,
        ]);
    }
}
