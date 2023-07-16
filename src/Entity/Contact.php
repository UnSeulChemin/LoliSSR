<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\ContactRepository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['contacts']]
)]
class Contact
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['contacts'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Email field can\'t be empty.')]
    #[Assert\Length(min: 5, max: 30,
        minMessage: 'Email shoud have at least {{ limit }} characters.',
        maxMessage: 'Email shoud have no more than {{ limit }} characters.')]
    #[Assert\Email(message: 'Email {{ value }} is not a valid email.')]
    #[Groups(['contacts'])]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Name field can\'t be empty.')]
    #[Assert\Length(min: 3, max: 20,
        minMessage: 'Name shoud have at least {{ limit }} characters.',
        maxMessage: 'Name should have no more than {{ limit }} characters.')]
    #[Groups(['contacts'])]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Subject field can\'t be empty.')]
    #[Assert\Length(min: 3, max: 30,
        minMessage: 'Subject should have at least {{ limit }} characters.',
        maxMessage: 'Subject should have no more than {{ limit }} characters.')]
    #[Groups(['contacts'])]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Message field can\'t be empty.')]
    #[Assert\Length(min: 3, max: 200,
        minMessage: 'Message should have at least {{ limit }} characters.',
        maxMessage: 'Message should have no more than {{ limit }} characters.')]
    #[Groups(['contacts'])]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['contacts'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}