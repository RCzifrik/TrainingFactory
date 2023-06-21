<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $preprovision = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateofbirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $street = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $place = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    public ?\DateTimeInterface $hiring_date = null;

    #[ORM\Column(nullable: true)]
    public ?int $social_sec_number = null;

    #[ORM\OneToMany(mappedBy: 'instructor', targetEntity: Lesson::class)]
    public Collection $lesson;

    #[ORM\OneToMany(mappedBy: 'member', targetEntity: Registration::class)]
    private Collection $registration;

    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 2, nullable: true)]
    private ?string $salary = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isTrainer = null;

    public function __construct()
    {
        $this->lesson = new ArrayCollection();
        $this->registration = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_MEMBER
        $roles[] = 'ROLE_MEMBER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPreprovision(): ?string
    {
        return $this->preprovision;
    }

    public function setPreprovision(?string $preprovision): static
    {
        $this->preprovision = $preprovision;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateofbirth(): ?\DateTimeInterface
    {
        return $this->dateofbirth;
    }

    public function setDateofbirth(\DateTimeInterface $dateofbirth): static
    {
        $this->dateofbirth = $dateofbirth;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getHiringDate(): ?\DateTimeInterface
    {
        return $this->hiring_date;
    }

    public function setHiringDate(?\DateTimeInterface $hiring_date): static
    {
        $this->hiring_date = $hiring_date;

        return $this;
    }

    public function getSocialSecNumber(): ?int
    {
        return $this->social_sec_number;
    }

    public function setSocialSecNumber(?int $social_sec_number): static
    {
        $this->social_sec_number = $social_sec_number;

        return $this;
    }

    /**
     * @return Collection<int, Lesson>
     */
    public function getLesson(): Collection
    {
        return $this->lesson;
    }

    public function addLesson(Lesson $lesson): static
    {
        if (!$this->lesson->contains($lesson)) {
            $this->lesson->add($lesson);
            $lesson->setInstructor($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): static
    {
        if ($this->lesson->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getInstructor() === $this) {
                $lesson->setInstructor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Registration>
     */
    public function getRegistration(): Collection
    {
        return $this->registration;
    }

    public function addRegistration(Registration $registration): static
    {
        if (!$this->registration->contains($registration)) {
            $this->registration->add($registration);
            $registration->setMember($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registration->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getMember() === $this) {
                $registration->setMember(null);
            }
        }

        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(?string $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function isIsTrainer(): ?bool
    {
        return $this->isTrainer;
    }

    public function setIsTrainer(?bool $isTrainer): static
    {
        $this->isTrainer = $isTrainer;

        return $this;
    }
}
