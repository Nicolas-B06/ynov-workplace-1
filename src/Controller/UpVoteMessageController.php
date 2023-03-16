<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Message;


class UpVoteMessageController extends AbstractController
{

    public function __invoke(Message $message)
    {
        $user = $this->getUser();
        $owner = $message->getOwner();
        if ($user !== $owner) {
            $message->setRating($message->getRating() + 1);
        }
        return $message;
    }
}