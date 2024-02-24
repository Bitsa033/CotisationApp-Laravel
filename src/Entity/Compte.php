<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $solde;

    /**
     * @ORM\ManyToOne(targetEntity=caisse::class, inversedBy="comptes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $caisse;

    /**
     * @ORM\ManyToOne(targetEntity=inscription::class, inversedBy="comptes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inscription;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolde(): ?float
    {
        return $this->solde;
    }

    public function setSolde(float $solde): self
    {
        $this->solde = $solde;

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
