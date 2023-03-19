<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetConversationCollectionController extends AbstractController
{
  public function __invoke(): array
  {
    $user = $this->getUser();
    /** @var User $user */
    $createdConversations = $user->getCreatedConversations()->getValues();
    $invitedConversations = $user->getInvitedConversations()->getValues();
    return array_merge($createdConversations, $invitedConversations);
  }
}
