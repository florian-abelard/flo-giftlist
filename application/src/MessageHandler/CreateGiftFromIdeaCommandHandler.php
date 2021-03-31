<?php

namespace App\MessageHandler;

use App\Dto\CreateGiftFromIdeaCommand;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class CreateGiftFromIdeaCommandHandler implements MessageHandlerInterface
{
    public function __invoke(CreateGiftFromIdeaCommand $command)
    {
        // do something with the resource
        dump($command);
    }
}
