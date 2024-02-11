<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use App\Services\CompteService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends CompteService
{
    /**
     * lien pour afficher tous les comptes
     * @Route("/", name="comptes")
     */
    public function listeComptes(CompteService $service): Response
    {
        return $this->render('back/index.html.twig', [
            'comptes' => $this->getRepo()->findAll()
        ]);
    }

    /**
     * lien pour ajouter une somme dans le compte
     * @Route("depotCompte", name="depotCompte")
     */
    function depotCompte(Request $request)
    {
        $id=$request->request->get('id');
        $somme=$request->request->get('somme');
        if (!empty($id) && !empty($somme)) { 
            $compte=$this->getId($id);
            if (!$compte) {
                return $this->json([
                    'message'=>'Erreur, Ce compte n\'existe pas dans notre base de données ! ',
                    'icon'=>'error',
                ]);
            }
            
            else {
                $this->crediter($id,$somme);
                
                return $this->json([
                    'message'=>'Ok, Dépot effectué avec success',
                    'icon'=>'success',
                ]);
                
            }

        }
        else {
            return $this->json([
                'message'=>'Erreur, Votre formulaire ne doit pas etre vide... Remplissez-le',
                'icon'=>'error'
            ]);
        }
    }

    /**
     * lien pour ajouter une somme dans le compte
     * @Route("retraitCompte", name="retraitCompte")
     */
    function retraitCompte(Request $request)
    {
        $id=$request->request->get('id');
        $somme=$request->request->get('somme');
        $id_compte=$this->getRepo()->find($id);
        $solde_courant=$id_compte->getSolde();
        
        //dd($solde_courant);
        if (!empty($id) && !empty($somme)) { 
            if ($solde_courant<$somme) {
                return $this->json([
                    'message'=>'Erreur, Votre solde est insuffisant, veuillez recharger votre compte et recommencez ! ',
                    'icon'=>'error',
                ]);
            }
            
            else {
                $this->debiter($id_compte,$somme);
                
                return $this->json([
                    'message'=>'Ok, Retrait effectué avec success',
                    'icon'=>'success',
                ]);
                
            }

        }
        else {
            return $this->json([
                'message'=>'Erreur, Votre formulaire ne doit pas etre vide... Remplissez-le',
                'icon'=>'error'
            ]);
        }
    }

    /**
     * lien pour ajouter une somme dans le compte
     * @Route("virerMontant", name="virerMontant")
     */
    function virer(Request $request)
    {
        // $id_post_deb=$request->request->get('id_post_deb');
        $id_post_cred=$request->query->get('id_post_cred');
        $somme=$request->request->get('somme');
        // $compteDeb=$this->getRepo()->find($id_post_deb);
        // $solde_courant=$compteDeb->getSolde();
        $compteCred=$this->getRepo()->findOneBy(['numero'=>$id_post_cred]);
        // dd($compteCred);
        return $this->json([
            'message'=>$compteCred,
            'icon'=>'error'
        ]);
    }

}
