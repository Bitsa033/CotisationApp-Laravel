<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Services\Clients;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/", name="app_ajax")
     */
    public function index(Clients $clients): Response
    {

        return $this->render('client/index.html.twig', [
            'clients'=>$clients->getAll()
        ]);
    }

    /**
     * @Route("ajouterClient", name="ajouterClient")
     */
    public function insert(Request $request,Clients $clients)
    {
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($nom) && !empty($contact)) {
           $create=$clients->create(compact("nom","contact"));
           $clients->save($create);
            return $this->json([
                'message'=>'Vos données ont été enregistrer avec success',
                'icon'=>'success',
                'debug'=>$clients
            ]);
            
            
        }
        else {
            return $this->json([
                'message'=>'Votre formulaire ne doit pas etre vide... Remplissez-le',
                'icon'=>'error'
            ]);
        }

    }
    /**
     * @Route("delete", name="deleteClient")
     */
    public function delete(Clients $clients)
    {
        $clients->delete();
        return new Response('Données supprimés avec succès !');

    }
}
