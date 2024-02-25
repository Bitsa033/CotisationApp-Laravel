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
        $id_compte_courant = $sessionInterface->get("id_compte_courant");
        $post_montant = $request->request->get('montant');
        $post_contact_receveur = $request->request->get('contact');
        $post_nom_caisse = $request->request->get('nom_caisse');
        $compteReceveur_array = $dataBaseService->membreRepository->findBy([
            'contact' => $post_contact_receveur
        ]);
        return $compteReceveur_array;

        // foreach ($compteReceveur_array as $key => $value) {

        //     $id_compte_rec = $value->getId();
        //     $this->virerMontant($id_compte_courant, $post_montant, $id_compte_rec);
        // }

        // return $this->json([
        //     'message' => 'Ok, Transfert effectué avec success',
        //     'icon' => 'success',
        // ]);
    }
}
