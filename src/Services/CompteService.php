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
    $c= $this->getRepo()->find($numeroCompte);
    $solde_courant=$c->getSolde();
    $solde_actuel=$solde_courant-$montant;
    $c->setSolde($solde_actuel);
    $this->save($c);
  }

  public function crediter($numeroCompte, $montant)
  {
    $c= $this->getRepo()->find($numeroCompte);
    $solde_courant=$c->getSolde();
    $solde_actuel=$solde_courant+$montant;
    $c->setSolde($solde_actuel);
    $this->save($c);
  }

  public function consulter($numeroCompte)
  {
  }

  public function virerMontant($numeroCompteDebiteur, $montant, $numeroCompteCrediteur)
  {
    $this->debiter($numeroCompteDebiteur,$montant);
    $this->crediter($numeroCompteCrediteur,$montant);
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
