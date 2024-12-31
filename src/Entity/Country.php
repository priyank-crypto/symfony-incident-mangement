<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\Table(name: 'countries')]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(name: "shortname", length: 10, nullable: true)]
    private ?string $shortName = null;

    #[ORM\Column(name: "phonecode")]
    private ?int $countryCode = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: States::class)]
    private Collection $states;

    public function __construct()
    {
        $this->states = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(?string $shortName): static
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getCountryCode(): ?int
    {
        return $this->countryCode;
    }

    public function setCountryCode(int $countryCode): static
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return Collection<int, States>
     */
    public function getStates(): Collection
    {
        return $this->states;
    }

    public function addState(States $state): static
    {
        if (!$this->states->contains($state)) {
            $this->states[] = $state;
            $state->setCountry($this);
        }

        return $this;
    }

    public function removeState(States $state): static
    {
        if ($this->states->removeElement($state)) {
            // Set the owning side to null (if no other state references this country)
            if ($state->getCountry() === $this) {
                $state->setCountry(null);
            }
        }

        return $this;
    }
}
