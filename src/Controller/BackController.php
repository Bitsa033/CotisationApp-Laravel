<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use App\Services\C2;
use App\Services\CompteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * lien pour afficher tous les comptes
     * @Route("/", name="comptes")
     */
    public function index(CompteService $service): Response
    {
        return $this->render('back/index.html.twig', [
            'comptes' => $service->getRepo()->findAll()
        ]);
    }

    /**
     * lien pour ajouter une somme dans le compte
     * @Route("depotCompte", name="depotCompte")
     */
    function depotCompte(Request $request,CompteService $service)
    {
        $id=$request->request->get('id');
        $somme=$request->request->get('somme');
        if (!empty($id) && !empty($somme)) { 
            $compte=$service->getId($id);
            if (!$compte) {
                return $this->json([
                    'message'=>'Erreur, Ce compte n\'existe pas dans notre base de données ! ',
                    'icon'=>'error',
                ]);
            }
            else {
                $service->debiter($id,$somme);
                
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
    function retraitCompte(Request $request,CompteService $service,CompteRepository $k)
    {
        $id=$request->request->get('id');
        $somme=$request->request->get('somme');
        $id_compte=$k->find($id);
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
                $create=$service->debiter($id_compte,$somme);
                
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

}
