<?php

namespace App\Controller;

use App\Entity\Conversation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PostConversationController extends AbstractController
{
  public function __invoke(Conversation $conversation): Conversation
  {
    /** @var User $user */
    $user = $this->getUser();
    if ($user !== $conversation->getGuest()) {
      return $conversation;
    } else {
      throw new BadRequestException();
    }
  }
}
