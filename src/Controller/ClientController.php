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
     * lien qui affiche la liste des clients
     * @Route("clients", name="clients")
     */
    public function index(Clients $service): Response
    {
        // dd($d=$clients->readOneData(8));
        return $this->render('client/index.html.twig', [
            'clients'=>$service->getAll()
        ]);
    }

    /**
     * lien pour enregistrer un client et son compte
     * @Route("insertClient", name="insertClient")
     */
    public function insertClient(Request $request,Clients $service)
    {
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($nom) && !empty($contact)) {
           $service->createData(compact("nom","contact"));
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
     * lien pour consulter un seul client et son compte, par son id
     * @Route("consulterClient_{id}", name="consulterClient")
     */
    function consulterClient(ClientRepository $client,$id)
    {
        $r=$client->find($id);
        $id2=$r->getId();
        $nom=$r->getNom();
        $contact=$r->getContact();
        $solde_du_compte=$r->getCompte()->getSolde();
        $compte_id=$r->getCompte()->getId();
        $numero_de_compte=$r->getCompte()->getNumero();
        return $this->json([
            'id'=>$id2,
            'nom'=>$nom,
            'contact'=>$contact,
            'solde_du_compte'=>$solde_du_compte,
            'compte_id'=>$compte_id,
            'numero_de_compte'=>$numero_de_compte,
            'icon'=>'success'
        ]);
        
        
    }

    /**
     * lien pour modifier un client qu'on a déja enregistré
     * @Route("updateClient", name="updateClient")
     */
    function updateClient(Request $request,Clients $service)
    {
        $id=$request->request->get('id');
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($id) && !empty($nom) && !empty($contact)) { 
            $client=$service->getId($id);
            if (!$client) {
                return $this->json([
                    'message'=>'Erreur, Ce client n\'existe pas dans notre base de données ! ',
                    'icon'=>'error',
                ]);
            }
            else {
                $create=$service->updateData(compact("client","nom","contact"));
                
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
    public function deleteClient(Clients $service)
    {
        $service->delete();
        
        return $this->json([
            'message'=>'Ok, la base de donnée est vide !',
            'icon'=>'success'
        ]);

    }

    /**
     * lien pour supprimer un seul client
     * @Route("deleteOneClient_{id}", name="deleteOneClient")
     */
    public function deleteOneClient(Clients $service,$id)
    {
        if (!empty($id)) {
            $service->deleteOne($id);
            
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
