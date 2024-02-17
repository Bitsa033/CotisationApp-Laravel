<?php

namespace App\Controller;
use App\Services\ClientService;
use App\Services\DataBaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * lien qui affiche la liste des membres
     * @Route("/", name="membres")
     */
    public function findAllData(ClientService $service): Response
    {
        // dd($d=$clients->readOneData(8));
        return $this->render('compte/listeComptes.html.twig', [
            'comptes'=>$service->findAllData()
        ]);
    }

    /**
     * lien pour enregistrer un client et son compte
     * @Route("insertClient", name="insertClient")
     */
    public function insertData(Request $request,ClientService $service)
    {
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($nom) && !empty($contact)) {
        //    $service->createData(compact("nom","contact"));
           $this->addFlash('success','Donnée enregistrée avec succès');
            // return $this->json([
            //     'message'=>'Ok, Données enrgistrées avec success',
            //     'icon'=>'success',
            // ]);

            return $this->render('client/index.html.twig', [
                'clients'=>$service->findAllData()
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
     * @Route("consulterClient/{id}", name="consulterClient")
     */
    function findOneData(ClientService $service,$id)
    {
        $id_client=$service->findAOneData($id);
        $nom=$id_client->getNom();
        $contact=$id_client->getContact();
        // $solde_du_compte=$client->getCompte()->getSolde();
        // $compte_id=$client->getCompte()->getId();
        // $numero_de_compte=$client->getCompte()->getNumero();
        return $this->json([
            'id'=>$id_client,
            'nom'=>$nom,
            'contact'=>$contact,
            // 'solde_du_compte'=>$solde_du_compte,
            // 'compte_id'=>$compte_id,
            // 'numero_de_compte'=>$numero_de_compte,
            'icon'=>'success'
        ]);
        
        
    }

    /**
     * lien pour modifier un client qu'on a déja enregistré
     * @Route("updateClient", name="updateClient")
     */
    function updateData(Request $request,ClientService $service)
    {
        $id=$request->request->get('id');
        $nom=$request->request->get('nom');
        $contact=$request->request->get('contact');
        if (!empty($id) && !empty($nom) && !empty($contact)) { 
            $client=$service->findAOneData($id);
            if (!$client) {
                return $this->json([
                    'message'=>'Erreur, Ce client n\'existe pas dans notre base de données ! ',
                    'icon'=>'error',
                ]);
            }
            else {
                $create=$service->updateData(compact("client","nom","contact"));
                
                // return $this->json([
                //     'message'=>'Ok, Données modifiées avec success',
                //     'icon'=>'success',
                // ]);
                return $this->redirect('membres');
                
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
    public function deleteAllData(DataBaseService $service)
    {
        $service->deleteAll($service->inscriptionRepository);
        
        // return $this->json([
        //     'message'=>'Ok, liste des données supprimée avec succès !',
        //     'icon'=>'success'
        // ]);

        return $this->redirect('membres');

    }

    /**
     * lien pour supprimer un seul client
     * @Route("deleteOneClient_{id}", name="deleteOneClient")
     */
    public function deleteOneData(ClientService $service,$id)
    {
        if (!empty($id)) {
            $service->deleteOneData($id);
            
            // return $this->json([
            //     'message'=>'Ok, le client a été supprimé !',
            //     'icon'=>'success'
            // ]);
            return $this->redirect('membres');

        }
        else {
            return $this->json([
                'message'=>'Erreur, Vous devez préciser l\'identifiant du client !',
                'icon'=>'error'
            ]);
        }


    }
}
