<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    private ?Doctors $DoctorBeTuday = null;

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

    public function getDoctorBeTuday(): ?Doctors
    {
        return $this->DoctorBeTuday;
    }

    public function setDoctorBeTuday(?Doctors $DoctorBeTuday): static
    {
        $this->DoctorBeTuday = $DoctorBeTuday;

        return $this;
    }


    /**
     * @return mixed
     */
    #[ArrayShape([
        'id' => "int|null",
        'name' => "null|string",
        'doctor_be_tuday_id' => "int|null",
    ])] public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'doctor_be_tuday_id' => $this->getDoctorBeTuday(),
        ];
    }
}
