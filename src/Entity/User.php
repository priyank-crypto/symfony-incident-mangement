<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity()]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "First name is required.")]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Last name is required.")]
    private ?string $lastName = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "Email is required.")]
    #[Assert\Email(message: "Please enter a valid email address.")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Address is required.")]
    private ?string $address = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Country is required.")]
    private ?string $country = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "State is required.")]
    private ?string $state = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "City is required.")]
    private ?string $city = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: "Pincode is required.")]
    #[Assert\Regex(pattern: "/^\d{5,10}$/", message: "Pincode must be numeric and between 5-10 digits.")]
    private ?string $pincode = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message: "Mobile number is required.")]
    #[Assert\Regex(pattern: "/^\d{10,15}$/", message: "Mobile number must be between 10-15 digits.")]
    private ?string $mobile = null;

    #[ORM\Column(length: 15, nullable: true)]
    # #[Assert\Regex(pattern: "/^\d{10,15}$/", message: "Fax number must be between 10-15 digits.")]
    private ?string $fax = null;

    #[ORM\Column(length: 15, nullable: true)]
    # #[Assert\Regex(pattern: "/^\d{10,15}$/", message: "Phone number must be between 10-15 digits.")]
    private ?string $phone = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Password is required.")]
    #[Assert\Length(min: 8, max: 64, minMessage: "Password must be at least 8 characters long.")]
    private ?string $password = null;

    #[Assert\NotBlank(message: "Confirm password is required.")]
    #[Assert\Expression(
        "this.getPassword() === this.getConfirmPassword()",
        message: "Passwords do not match."
    )]
    private ?string $confirmPassword = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "User type is required.")]
    #[Assert\Choice(choices: ['individual', 'employee', 'government'], message: "Choose a valid user type.")]
    private ?string $userType = null;

    #[ORM\OneToMany(mappedBy: 'reporter', targetEntity: Incident::class)]
    private Collection $incidents;

    public function __construct()
    {
        $this->incidents = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getPincode(): ?string
    {
        return $this->pincode;
    }

    public function setPincode(string $pincode): self
    {
        $this->pincode = $pincode;
        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
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

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void {}

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUserType(): ?string
    {
        return $this->userType;
    }

    public function setUserType(string $userType): self
    {
        $this->userType = $userType;
        return $this;
    }

    /**
     * @return Collection|Incident[]
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    public function addIncident(Incident $incident): self
    {
        if (!$this->incidents->contains($incident)) {
            $this->incidents->add($incident);
            $incident->setReporter($this);
        }

        return $this;
    }

    public function removeIncident(Incident $incident): self
    {
        if ($this->incidents->removeElement($incident)) {
            if ($incident->getReporter() === $this) {
                $incident->setReporter(null);
            }
        }

        return $this;
    }
}
