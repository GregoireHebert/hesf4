<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Services\Library;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CustomVoter extends Voter
{
    public const CRITERIA = 'criteriaOfSuccess';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if ($attribute !== self::CRITERIA) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Library) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to supports
        /** @var Library $library */
        $library = $subject;

        return $user->getUsername() === $library->getOwner();
    }
}
