<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use App\Services\C2;
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
    public function index(C2 $service): Response
    {
        return $this->render('back/index.html.twig', [
            'comptes' => $service->getAll(),
        ]);
    }

    /**
     * lien pour ajouter une somme dans le compte
     * @Route("depotCompte", name="depotCompte")
     */
    function depotCompte(Request $request,C2 $service, CompteRepository $c)
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
                $create=$service->depot(compact("compte","somme"),$c);
                
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
    function retraitCompte(Request $request,C2 $service, CompteRepository $c)
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
                $create=$service->retrait(compact("compte","somme"),$c);
                
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
