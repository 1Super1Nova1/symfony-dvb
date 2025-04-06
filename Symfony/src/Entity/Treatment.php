<?php

namespace App\Entity;

use App\Repository\TreatmentRepository;
use Doctrine\ORM\Mapping as ORM; 
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

#[ORM\Entity(repositoryClass: TreatmentRepository::class)]
class Treatment implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patients $patient = null;

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

    public function getPatient(): ?Patients
    {
        return $this->patient;
    }

    public function setPatient(?Patients $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    
    /**
     * @return mixed
     */
    #[ArrayShape([
        'id'          => "int|null",
        'name'        => "null|string",
    ])] public function jsonSerialize(): mixed
    {
        return [
            'id'          => $this->getId(),
            'name'        => $this->getName(),
        ];
    }
}
