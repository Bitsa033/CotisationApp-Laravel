<?php

namespace App\Controller;

use App\Services\CompteService;
use App\Services\DataBaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends CompteService
{

    /**
     * lien pour ajouter une somme dans le compte
     * @Route("depotCompte", name="depotCompte")
     */
    function depotCompte($id_compte, $montant, DataBaseService $dataBaseService)
    {
        if (!empty($id_compte) && !empty($montant)) {

            $id_compte_db = $dataBaseService->caisseRepository->find($id_compte);

            if (!$id_compte_db) {

                return $this->json([
                    'message' => 'Erreur, Ce compte n\'existe pas dans notre base de données ! ',
                    'icon' => 'error',
                ]);
            } else {

                $this->crediter($id_compte_db, $montant);

                return $this->json([
                    'message' => 'Ok, Dépot effectué avec success',
                    'icon' => 'success',
                ]);
            }
        } else {

            return $this->json([
                'message' => 'Erreur, Votre formulaire ne doit pas etre vide... Remplissez-le',
                'icon' => 'error'
            ]);
        }
    }

    /**
     * lien pour ajouter une somme dans le compte
     * @Route("retraitCompte", name="retraitCompte")
     */
    function retraitCompte($id_compte, $montant, DataBaseService $dataBaseService)
    {

        //dd($solde_courant);
        if (!empty($id_compte) && !empty($montant)) {

            $id_compte_db = $dataBaseService->cotisationRepository->find($id_compte);
            $solde_courant = $id_compte_db->getMontant();

            if (!$id_compte_db) {

                return $this->json([
                    'message' => 'Erreur, Ce compte n\'existe pas dans notre base de données ! ',
                    'icon' => 'error',
                ]);
            } elseif ($solde_courant < $montant) {

                return $this->json([
                    'message' => 'Erreur, Votre solde est insuffisant, veuillez recharger votre compte et recommencez ! ',
                    'icon' => 'error',
                ]);
            } else {
                $this->debiter($id_compte_db, $montant);

                return $this->json([
                    'message' => 'Ok, Retrait effectué avec success',
                    'icon' => 'success',
                ]);
            }
        } else {
            return $this->json([
                'message' => 'Erreur, Votre formulaire ne doit pas etre vide... Remplissez-le',
                'icon' => 'error'
            ]);
        }
    }

    /**
     * lien pour transferer de l'argent d'un compte à un autre
     * @Route("virerMontant", name="virerMontant")
     */
    function virerArgent(Request $request, SessionInterface $sessionInterface,DataBaseService $dataBaseService)
    {
        $message='Ok, transfert éffectué !';
        //on doit recuperer l'id de la table inscription pour l'envoyeur et le receveur
        //on doit recuperer le montant à envoyer au receveur
        //on doit recuperer la caisse à débiter pour l'envoyeur et celle à créditer pour le receveur
        //on doit recuperer l'id du compte de l'envoyeur et du receveur selon la caisse et le membre
        //on doit débiter la caisse de l'envoyeur  et créditer celle du receveur
        //......................................................................................

        //on récupere l'id de la table inscription pour l'envoyeur
        $id_compte_courant = $sessionInterface->get("id_compte_courant");
        $envoyeur=$dataBaseService->inscriptionRepository->find($id_compte_courant);
        //on récupere l'id de la table inscription pour le receveur
        $post_contact_receveur = $request->request->get('contact');
        $compteReceveur_array = $dataBaseService->membreRepository->findBy([
            'contact' => $post_contact_receveur
        ]);

        foreach ($compteReceveur_array as $key => $value) {
            $id_membre=$value->getId();
        }

        $receveur=$dataBaseService->inscriptionRepository->find($id_membre);
        //on récupere le montant à envoyer au receveur
        $post_montant = $request->request->get('montant');
        //on recupere la caisse à débiter pour l'envoyeur et celle à créditer pour le receveur
        $post_nom_caisse = $request->request->get('nom_caisse');
        $caisse_array = $dataBaseService->caisseRepository->findBy([
            'nom' => $post_nom_caisse
        ]);

        foreach ($caisse_array as $key => $value) {
            $id_caisse=$value->getId();
        }

        //on recupere l'id du compte de l'envoyeur selon la caisse et le membre
        $compte_envoyeur_array=$dataBaseService->compteRepository->findBy([
            'caisse'=>$id_caisse,
            'inscription'=>$envoyeur
        ]);

        //on débite la caisse de l'envoyeur
        foreach ($compte_envoyeur_array as $key => $value) {
            $solde_caisse=$value->getSolde();
            $retrait=$solde_caisse - $post_montant;
            $value->setSolde($retrait);
            $dataBaseService->write();

        }

        //on recupere l'id du compte du receveur selon la caisse et le membre
        $compte_receveur_array=$dataBaseService->compteRepository->findBy([
            'caisse'=>$id_caisse,
            'inscription'=>$receveur
        ]);
        //on crédite la caisse du receveur
        foreach ($compte_receveur_array as $key => $value) {
            $solde_caisse=$value->getSolde();
            $depot=$solde_caisse + $post_montant;
            $value->setSolde($depot);
            $dataBaseService->write();
        }

        return $message;

        
    }
}
