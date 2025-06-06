<?php

namespace App\Entity;

use App\Repository\DiagnosesRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

#[ORM\Entity(repositoryClass: DiagnosesRepository::class)]
class Diagnoses implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $diagnosesName = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Doctors $diagnosisMade = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patients $diagnosisHave = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiagnosesName(): ?string
    {
        return $this->diagnosesName;
    }

    public function setDiagnosesName(string $diagnosesName): static
    {
        $this->diagnosesName = $diagnosesName;

        return $this;
    }

    public function getDiagnosisMade(): ?Doctors
    {
        return $this->diagnosisMade;
    }

    public function setDiagnosisMade(?Doctors $diagnosisMade): static
    {
        $this->diagnosisMade = $diagnosisMade;

        return $this;
    }

    public function getDiagnosisHave(): ?Patients
    {
        return $this->diagnosisHave;
    }

    public function setDiagnosisHave(?Patients $diagnosisHave): static
    {
        $this->diagnosisHave = $diagnosisHave;

        return $this;
    }

    
    /**
     * @return mixed
     */
    #[ArrayShape([
        'id'          => "int|null",
        'diagnoses_name'       => "null|string",
        'diagnosis_have_id '       => "null|string",
        'diagnosis_made_id '       => "null|string"
    ])] public function jsonSerialize(): mixed
    {
        return [
            'id'          => $this->getId(),
            'diagnoses_name'       => $this->getDiagnosesName(),
            'diagnosis_have_id '       => $this->getDiagnosisHave(),
            'diagnosis_made_id '       => $this->getDiagnosisMade(),
        ];
    }
}
