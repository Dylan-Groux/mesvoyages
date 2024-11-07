<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[Assert\NoBlank() ]
    #[Assert\Length (min:2, max:100) ]
    private ?string $nom;

    #[Assert\NoBlank() ]
    #[Assert\Email() ]
    private ?string $email;


    #[Assert\NoBlank() ]
    private ?string $message;

    // Getter et Setter pour $nom
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    // Getter et Setter pour $email
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    // Getter et Setter pour $message
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }
}
