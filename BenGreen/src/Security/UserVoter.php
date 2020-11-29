<?php
namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter {

    // définition d'un constante contenant la/les action(s) à surveiller
    const EDIT = 'edit';

    //$attribute = action définie
    //$subject = ce sur quoi se fait le vote
    protected function supports($attribute, $subject)
    {
        // l'attribut n'est pas dans la liste - if the attribute isn't one we support, return false :
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }
        // si $subject n'est pas une instance de User : only vote on `User` objects
        if (!$subject instanceof User) {
            return false;
        }

        //Si la fonction supports() retourne true, on a donc bien un utilisateur connecté, qui cherche à avoir accès à l'édition du profil. La fonction voteOnAttribute() est ensuite exécutée:
        // si retourne true, appel de voteOnAttribute()
        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        //récupérer l'utilisateur courant :
        $user = $token->getUser();

        //vérifier si l'utilisateur passé en paramètre de la fonction est bien une instance de la classe User :
        if (!$user instanceof User) {
            // l'utilisateur doit être connecté, sinon accès refusé
            return false;
        }

        //Grâce à supports() nous savons que $subject est un objet de la classe User, nous le stockons dans une variable :
        $utilisateur = $subject;

        //ensuite, étudions les différents cas définis (edit pour l'exemple, il peut y en avoir plus selon la gestion des autorisations), et pour chaque cas, on va vérifier que l'utilisateur connecté est bien celui qui est attendu :
        switch ($attribute) {
            case self::EDIT:
                return $user->getId() == $utilisateur->getId();
        }

        throw new \LogicException('This code should not be reached!');

    }
}