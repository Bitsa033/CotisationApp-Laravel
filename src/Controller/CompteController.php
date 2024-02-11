<?php

namespace App\Controller;

use App\Services\CompteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends CompteService
{

    /**
     * lien pour afficher tous les comptes
     * @Route("listeComptes", name="listeComptes")
     */
    function listeComptes():Response
    {
        return $this->render("compte/listeComptes.html.twig",[
            'comptes' => $this->getRepo()->findAll()
        ]);
    }

    /**
     * lien pour crediter un compte
     * @Route("crediterCompte", name="crediterCompte")
     */
    function crediterCompte():Response
    {
        return $this->render("compte/crediterCompte.html.twig",[
            'comptes' => $this->getRepo()->findAll()
        ]);
    }

    /**
     * lien pour debiter un compte
     * @Route("debiterCompte", name="debiterCompte")
     */
    function debiterCompte():Response
    {
        return $this->render("compte/debiterCompte.html.twig",[
            'comptes' => $this->getRepo()->findAll()
        ]);
    }

    /**
     * lien pour transferer de l'argent
     * @Route("transfererArgent", name="transfererArgent")
     */
    function transfererArgent():Response
    {
        return $this->render("compte/transfererMontant.html.twig",[
            'comptes' => $this->getRepo()->findAll()
        ]);
    }

    
    /**
     * lien pour crediter un compte
     * @Route("crediterCompteB", name="crediterCompteB")
     */
    function crediterCompteB(Request $request)
    {
        
    }

    /**
     * lien pour crediter un compte
     * @Route("debiterCompteB", name="debiterCompteB")
     */
    function debiterCompteB(Request $request)
    {
        
    }


    /**
     * lien pour crediter un compte
     * @Route("transfererArgentB", name="transfererArgentB")
     */
    function transfererArgentB(Request $request)
    {
        
    }
}
