<?php

namespace App\Entity;

use App\Repository\CotisationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CotisationRepository::class)
 */
class Cotisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=caisse::class, inversedBy="cotisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $caisse;

    /**
     * @ORM\ManyToOne(targetEntity=inscription::class, inversedBy="cotisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inscription;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCaisse(): ?caisse
    {
        return $this->caisse;
    }

    public function setCaisse(?caisse $caisse): self
    {
        $this->caisse = $caisse;

        return $this;
    }

    public function getInscription(): ?inscription
    {
        return $this->inscription;
    }

    public function setInscription(?inscription $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }
}
