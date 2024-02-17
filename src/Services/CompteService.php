<?php

namespace App\Services;

use App\Entity\Compte;
use App\Repository\CompteRepository;

class CompteService  extends DataBaseService implements CompteInterface
{
  
  public function creer()
  {
  }

  function debiter($numeroCompte, $montant)
  {
    $c= $this->cotisationRepository->find($numeroCompte);
    $solde_courant=$c->getMontant();
    $solde_actuel=$solde_courant-$montant;
    $c->setMontant($solde_actuel);
    $this->save($c);
  }

  public function crediter($numeroCompte, $montant)
  {
    $c= $this->cotisationRepository->find($numeroCompte);
    $solde_courant=$c->getMontant();
    $solde_actuel=$solde_courant+$montant;
    $c->setMontant($solde_actuel);
    $this->save($c);
  }

  public function consulter($numeroCompte)
  {
    return $this->cotisationRepository->find($numeroCompte);
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
