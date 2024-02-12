<?php

namespace App\Controller;

use App\Services\ClientService;
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
        return $this->render("compte/nouveauCompte.html.twig", []);
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
            
        ]);
    }

    /**
     * lien pour transferer de l'argent
     * @Route("transfererArgent", name="transfererArgent")
     */
    function transfererArgent(Request $request, SessionInterface $sessionInterface): Response
    {
        $get_id_compte_courant = $request->query->get("id");
        $sessionInterface->set("id_compte_courant", $get_id_compte_courant);
    
        return $this->render("compte/transfererMontant.html.twig", []);
    }

    /**
     * lien pour enregistrer un client et son compte
     * @Route("nouveauCompteB", name="nouveauCompteB")
     */
    public function nouveauCompteB(Request $request,ClientService $service)
    {
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($nom) && !empty($contact)) {
           $service->createData(compact("nom","contact"));
           $this->addFlash('success','Création du compte réussi !');
            return $this->redirect('listeComptes');
              
        }
        else {
            $this->addFlash('erreur','Remplissez votre formulaire !');
            return $this->redirect('nouveauCompte');
        }

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
        $this->addFlash('success',"Dépot éffectué");
        return $this->redirect("listeComptes");
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
        $this->addFlash('success',"Retrait éffectué");
        return $this->redirect("listeComptes");
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
        $compteReceveur_array = $this->getRepo()->findBy(['numero' => $post_num_compte_receveur]);
        // dd($compteReceveur_array);
        if (empty($compteReceveur_array)) {
            
            $this->addFlash('erreur',"Numéro de compte introuvable !");
            return $this->redirect("transfererArgent");
        }

        foreach ($compteReceveur_array as $key => $value) {

            $id_compte_rec = $value->getId();
            $this->virerMontant($id_compte_courant, $post_montant, $id_compte_rec);
        }

        $this->addFlash('success',"Transfert éffectué");
        return $this->redirect("listeComptes");


    }
}
