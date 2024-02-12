<?php

namespace App\Controller;

use App\Services\CompteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends CompteService
{

    /**
     * lien pour afficher tous les comptes
     * @Route("listeComptes", name="listeComptes")
     */
    function listeComptes(): Response
    {
        return $this->render("compte/listeComptes.html.twig", [
            'comptes' => $this->getRepo()->findAll()
        ]);
    }

    /**
     * lien pour afficher tous les comptes
     * @Route("nouveauCompte", name="nouveauCompte")
     */
    function nouveauCompte(): Response
    {
        return $this->render("compte/nouveauCompte.html.twig", [
            'comptes' => $this->getRepo()->findAll()
        ]);
    }

    /**
     * lien pour crediter un compte
     * @Route("crediterCompte", name="crediterCompte")
     */
    function crediterCompte(Request $request, SessionInterface $sessionInterface): Response
    {
        $get_id_compte_courant = $request->query->get("id");
        $sessionInterface->set("id_compte_courant", $get_id_compte_courant);

        return $this->render("compte/crediterCompte.html.twig", [
            'comptes' => $this->getRepo()->findAll()
        ]);
    }

    /**
     * lien pour debiter un compte
     * @Route("debiterCompte", name="debiterCompte")
     */
    function debiterCompte(Request $request, SessionInterface $sessionInterface): Response
    {
        $get_id_compte_courant = $request->query->get("id");
        $sessionInterface->set("id_compte_courant", $get_id_compte_courant);
        return $this->render("compte/debiterCompte.html.twig", [
            'comptes' => $this->getRepo()->findAll()
        ]);
    }

    /**
     * lien pour transferer de l'argent
     * @Route("transfererArgent", name="transfererArgent")
     */
    function transfererArgent(Request $request, SessionInterface $sessionInterface): Response
    {
        $get_id_compte_courant = $request->query->get("id");
        $post_num_compte_receveur = $request->request->get("num_compte_receveur");
        $sessionInterface->set("id_compte_courant", $get_id_compte_courant);
        $sessionInterface->set("num_compte_receveur", $post_num_compte_receveur);
        // $num_compte_receveur=$sessionInterface->get("num_compte_receveur");
        // if (!empty($post_num_compte_receveur)) {
        //     # code...
        //     dd($num_compte_receveur);
        // }

        return $this->render("compte/transfererMontant.html.twig", []);
    }


    /**
     * lien pour crediter un compte
     * @Route("crediterCompteB", name="crediterCompteB")
     */
    function crediterCompteB(Request $request, BackController $backController, SessionInterface $sessionInterface)
    {
        $id_compte_courant = $sessionInterface->get("id_compte_courant");
        $post_montant = $request->request->get('montant');

        $backController->depotCompte($id_compte_courant, $post_montant);
        return $backController->message;

        // return $this->redirectToRoute("listeComptes");
    }

    /**
     * lien pour crediter un compte
     * @Route("debiterCompteB", name="debiterCompteB")
     */
    function debiterCompteB(Request $request, BackController $backController, SessionInterface $sessionInterface)
    {
        $id_compte_courant = $sessionInterface->get("id_compte_courant");
        $post_montant = $request->request->get('montant');

        $backController->retraitCompte($id_compte_courant, $post_montant);
        return $backController->message;
    }


    /**
     * lien pour crediter un compte
     * @Route("transfererArgentB", name="transfererArgentB")
     */
    function transfererArgentB(Request $request, BackController $backController, Session $sessionInterface)
    {
        $id_compte_courant = $sessionInterface->get("id_compte_courant");
        $post_montant = $request->request->get('montant');
        $post_num_compte_receveur = $request->request->get('num_compte_receveur');
        // if (!empty($post_num_compte_receveur)) {
        //     # code...
        //     dd($id_compte_courant,$post_montant,$post_num_compte_receveur);
        // }


        $backController->virer($id_compte_courant,$post_montant,$post_num_compte_receveur);
        // return $backController->numCompteRec;
    }
}
