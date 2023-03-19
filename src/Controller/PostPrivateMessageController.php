<?php

namespace App\Controller;

use App\Entity\PrivateMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PostPrivateMessageController extends AbstractController
{
  public function __invoke(PrivateMessage $privateMessage): PrivateMessage
  {
    /** @var User $user */
    $user = $this->getUser();
    $userConversations = array_merge($user->getCreatedConversations()->getValues(), $user->getInvitedConversations()->getValues());
    $conversation = $privateMessage->getConversation();
    if (in_array($conversation, $userConversations)) {
      return $privateMessage;
    } else {
      throw new AccessDeniedHttpException();
    }
  }
}
