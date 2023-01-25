<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Services\Clients;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * lien qui affiche la liste des clients
     * @Route("/", name="clients")
     */
    public function index(Clients $clients, Request $request): Response
    {
        if (!empty($request->request->get('idclient'))) {
            # code...
            dd($request->request->get('idclient'));
        }
        
        return $this->render('client/index.html.twig', [
            'clients'=>$clients->getAll()
        ]);
    }

    /**
     * lien pour enregistrer un client
     * @Route("insertClient", name="insertClient")
     */
    public function insertClient(Request $request,Clients $clients)
    {
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($nom) && !empty($contact)) {
           $create=$clients->create(compact("nom","contact"));
            return $this->json([
                'message'=>'Ok, Données enrgistrées avec success',
                'icon'=>'success',
                'debug'=>$clients
            ]);
            
        }
        else {
            return $this->json([
                'message'=>'Erreur, Votre formulaire ne doit pas etre vide... Remplissez-le',
                'icon'=>'error'
            ]);
        }

    }
    /**
     * lien pour consulter un seul client par son id
     * @Route("consulterClient_{id}", name="consulterClient")
     */
    function consulterClient(ClientRepository $clientRepository,$id)
    {
        
        $client=$clientRepository->find($id);
        $id2=$client->getId();
        $nom=$client->getNom();
        $contact=$client->getContact();
        return $this->json([
            'id'=>$id2,
            'nom'=>$nom,
            'contact'=>$contact,
            'icon'=>'success'
        ]);
        // return $this->render('client/consulter.html.twig',[
        //     'client'=>$client
        // ]);
    }

    /**
     * lien pour modifier un client qu'on a déja enregistré
     * @Route("updateClient", name="updateClient")
     */
    function updateClient(Request $request,ClientRepository $repo,ManagerRegistry $managerRegistry)
    {
        $id=$request->request->get('id');
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($id) && !empty($nom) && !empty($contact)) { 
            $product=$repo->find($id);
            if (!$product) {
                return $this->json([
                    'message'=>'Erreur, Ce client n\'existe pas dans notre base de données ! ',
                    'icon'=>'error',
                ]);
            }
            else {
                $product->setNom($nom);
                $product->setContact($contact);
                $manager=$managerRegistry->getManager();
                $manager->flush();
                return $this->json([
                    'message'=>'Ok, Données modifiées avec success',
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

    /**
     * lien pour supprimer un seul client
     * @Route("deleteOneClient", name="deleteOneClient")
     */
    public function deleteOneClient(Request $request,Clients $clients)
    {
        $id=$request->request->get('id');
        if (!empty($id)) {
            $clients->deleteOne($id);
            
            return $this->json([
                'message'=>'Ok, le client a été supprimé !',
                'icon'=>'success'
            ]);

        }
        else {
            return $this->json([
                'message'=>'Erreur, Vous devez préciser l\'identifiant du client !',
                'icon'=>'error'
            ]);
        }


    }
}
