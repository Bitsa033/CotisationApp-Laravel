<?php

namespace App\Controller;

use App\Services\ClientService;
use App\Services\CompteService;
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
     * lien pour créer un nouveau uncompte
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
     * lien pour enregistrer un nouveau compte
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
     * lien pour débiter un compte
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
     * lien pour transferer de l'argent d 'un compte à un autre
     * @Route("transfererArgentB", name="transfererArgentB")
     */
    function transfererArgentB(Request $request, BackController $backController, Session $sessionInterface)
    {
        $backController->virerArgent($request,$sessionInterface);

        $this->addFlash('success',"Transfert éffectué");
        return $this->redirect("listeComptes");


    }
}
