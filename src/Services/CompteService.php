<?php

namespace App\Services;

use App\Entity\Compte;
use App\Repository\CompteRepository;

class CompteService  extends DataBaseService implements CompteInterface
{
  
  public function __construct()
  {
    $this->table=Compte::class;
  }

  public function creer()
  {
  }

  function debiter($numeroCompte, $montant)
  {
  }

  public function crediter($numeroCompte, $montant)
  {
  }

  public function consulter($numeroCompte)
  {
  }

  public function virerMontant($numeroCompteDebiteur, $montant, $numeroCompteCrediteur)
  {
  }

  public function activer($numeroCompte)
  {
  }

  public function desactiver($numeroCompte)
  {
  }

  public function supprimer($numeroCompte)
  {
  }
}
