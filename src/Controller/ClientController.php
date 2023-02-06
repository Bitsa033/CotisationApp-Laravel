<?php

namespace App\Controller;
use App\Repository\ClientRepository;
use App\Services\C2;
use App\Services\Clients;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * lien qui affiche la liste des clients
     * @Route("clients", name="clients")
     */
    public function index(Clients $clients): Response
    {
        // dd($d=$clients->readOneData(8));
        return $this->render('client/index.html.twig', [
            'clients'=>$clients->getAll()
        ]);
    }

    /**
     * lien pour enregistrer un client et son compte
     * @Route("insertClient", name="insertClient")
     */
    public function insertClient(Request $request,Clients $client)
    {
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($nom) && !empty($contact)) {
           $client->createData(compact("nom","contact"));
            return $this->json([
                'message'=>'Ok, Données enrgistrées avec success',
                'icon'=>'success',
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
    function consulterClient(ClientRepository $client,$id)
    {
        $r=$client->find($id);
        $id2=$r->getId();
        $nom=$r->getNom();
        $contact=$r->getContact();
        $solde_du_compte=$r->getCompte()->getSolde();
        $numero_de_compte=$r->getCompte()->getNumero();
        return $this->json([
            'id'=>$id2,
            'nom'=>$nom,
            'contact'=>$contact,
            'solde_du_compte'=>$solde_du_compte,
            'numero_de_compte'=>$numero_de_compte,
            'icon'=>'success'
        ]);
        
        
    }

    /**
     * lien pour modifier un client qu'on a déja enregistré
     * @Route("updateClient", name="updateClient")
     */
    function updateClient(Request $request,Clients $repo)
    {
        $id=$request->request->get('id');
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($id) && !empty($nom) && !empty($contact)) { 
            $client=$repo->getId($id);
            if (!$client) {
                return $this->json([
                    'message'=>'Erreur, Ce client n\'existe pas dans notre base de données ! ',
                    'icon'=>'error',
                ]);
            }
            else {
                $create=$repo->updateData(compact("client","nom","contact"));
                
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
     * @Route("deleteOneClient_{id}", name="deleteOneClient")
     */
    public function deleteOneClient(Clients $clients,$id)
    {
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
