<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CandidatStageRepository")
 */
class CandidatStage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $candidat_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $stage_id;

    /**
     * @ORM\Column(type="date")
     */
    private $DatePostuler;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidatId(): ?int
    {
        return $this->candidat_id;
    }

    public function setCandidatId(int $candidat_id): self
    {
        $this->candidat_id = $candidat_id;

        return $this;
    }

    public function getStageId(): ?int
    {
        return $this->stage_id;
    }

    public function setStageId(int $stage_id): self
    {
        $this->stage_id = $stage_id;

        return $this;
    }

    public function getDatePostul(): ?\DateTimeInterface
    {
        return $this->DatePostul;
    }

    public function setDatePostul(\DateTimeInterface $DatePostul): self
    {
        $this->DatePostul = $DatePostul;

        return $this;
    }
}
