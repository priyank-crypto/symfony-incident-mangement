<?php

namespace App\Entity;

use App\Enum\IncidentStatus;
use App\Repository\IncidentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncidentRepository::class)]
class Incident
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'incidents')]
    #[ORM\JoinColumn(nullable: false)] // Ensures a user is always associated
    private ?User $reporter = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $incidentId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $incidentDetails = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $reportedDate = null;

    #[ORM\Column(length: 20)]
    private ?string $priority = null;

    #[ORM\Column(type: "string", enumType: IncidentStatus::class, options: ["default" => "open"])]
    private IncidentStatus $status = IncidentStatus::OPEN;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $entityType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReporter(): ?User
    {
        return $this->reporter;
    }

    public function setReporter(User $reporter): static
    {
        $this->reporter = $reporter;

        return $this;
    }

    public function getEntityType(): ?string
    {
        return $this->entityType;
    }

    public function setEntityType(string $entityType): self
    {
        $this->entityType = $entityType;
        return $this;
    }


    public function getIncidentId(): ?string
    {
        return $this->incidentId;
    }
    public function generateIncidentId(EntityManagerInterface $entityManager): ?string
    {
        $year = (new \DateTime())->format('Y');
        $randomNumber = random_int(10000, 99999);
        $generatedId = "RMG" . $randomNumber . $year;

        // Ensure uniqueness
        $existingIncident = $entityManager->getRepository(Incident::class)->findOneBy(['incidentId' => $generatedId]);
        if ($existingIncident) {

            return $this->generateIncidentId($entityManager);
        }

        return $generatedId;
    }

    public function setIncidentId(string $incidentId): static
    {
        $this->incidentId = $incidentId;

        return $this;
    }

    public function getIncidentDetails(): ?string
    {
        return $this->incidentDetails;
    }

    public function setIncidentDetails(?string $incidentDetails): static
    {
        $this->incidentDetails = $incidentDetails;

        return $this;
    }

    public function getReportedDate(): ?\DateTimeInterface
    {
        return $this->reportedDate;
    }

    public function setReportedDate(?\DateTimeInterface $reportedDate): static
    {
        $this->reportedDate = $reportedDate;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getStatus(): ?IncidentStatus
    {
        return $this->status;
    }

    public function setStatus(IncidentStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}
