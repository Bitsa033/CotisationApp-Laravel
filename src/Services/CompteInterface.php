<?php
namespace App\Services;

interface CompteInterface{

    function creer();
    function crediter($numeroCompte,$montant);
    function debiter($numeroCompte,$montant);
    function virerMontant($numeroCompteDebiteur,$montant,$numeroCompteCrediteur);
    function consulter($numeroCompte);
    function supprimer($numeroCompte);
    function activer($numeroCompte);
    function desactiver($numeroCompte);

}