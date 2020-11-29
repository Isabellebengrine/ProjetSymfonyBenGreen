<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Cet e-mail est déjà utilisé !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     * @Assert\EqualTo(propertyPath="confirmPassword", message="Vous n'avez pas tapé le même mot de passe")
     */
    private $password;

    /** if we want to ask to repeat password
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapé le même mot de passe")
     */
    //private $confirmPassword;

    /**
     * @ORM\Column(type="string", length=255, options={"default" : "client"})
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRoles()
    {
        if ($this->role == "administrateur")
            return ["ROLE_ADMIN"];
        if ($this->role == "client")
            return ["ROLE_USER"];
        return [];
    }

    public function getSalt()
    {
        // nous ne définissons pas méthode spécifique de chiffrement, donc la méthode retournera une chaine de caractère vide :
        return "";
    }

    public function getUsername()
    {
        // Puisque nous utilisons une propriété différente de username pour notre identification, nous devons indiquer à quelle propriété correspond username. Dans notre cas, l'adresse mail servira d'identifiant à notre utilisateur. Nous aurons donc :
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
