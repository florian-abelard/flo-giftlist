<?php

namespace App\MessageHandler;

use App\Dto\CreateGiftFromIdeaCommand;
use App\Entity\Gift;
use App\Entity\Idea;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateGiftFromIdeaCommandHandler implements MessageHandlerInterface
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateGiftFromIdeaCommand $command)
    {
        $gift = $this->createGift(
            $command->getIdea(),
            $command->getEventYear(),
            $command->getRecipients(),
        );
        $this->entityManager->persist($gift);

        // $idea = $idea->udpateIdeaRecipients($command->getRecipients());

        // if (count($idea->getRecipients()) === 0) {
        //     $this->entityManager->remove($idea);
        // } else {
        //     $this->entityManager->persist($idea);
        // }

        $this->entityManager->flush();
    }

    public function createGift(Idea $idea, string $eventYear, array $recipients): Gift
    {
        $gift = new Gift();

        $gift->setLabel($idea->getLabel());
        $gift->setPrice($idea->getPrice());
        $gift->setEventYear($eventYear);

        foreach ($recipients as $recipient) {
            $gift->addRecipient($recipient);
        }

        return $gift;
    }
}
