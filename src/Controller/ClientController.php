<?php

namespace App\Controller;
use App\Services\Clients;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/", name="clients")
     */
    public function index(Clients $clients): Response
    {

        return $this->render('client/index.html.twig', [
            'clients'=>$clients->getAll()
        ]);
    }

    /**
     * lien pour enregistrer un clien
     * @Route("insertClient", name="insertClient")
     */
    public function insertClient(Request $request,Clients $clients)
    {
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($nom) && !empty($contact)) {
           $create=$clients->create(compact("nom","contact"));
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
     * lien pour supprimer tous les clients
     * @Route("deleteClient", name="deleteClient")
     */
    public function deleteClient(Clients $clients)
    {
        $clients->delete();
        
        return $this->json([
            'message'=>'Ok, la base de donnée est vide !',
            'icon'=>'success'
        ]);


    }
}
