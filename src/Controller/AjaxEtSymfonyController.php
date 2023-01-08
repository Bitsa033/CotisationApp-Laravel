<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AjaxEtSymfonyController extends AbstractController
{
    /**
     * @Route("/", name="app_ajax")
     */
    public function index(ClientRepository $clientRepository): Response
    {
    
        return $this->render('clients/index.html.twig', [
            'clients'=>$clientRepository->findAll()
        ]);
    }

    /**
     * @Route("ajouterClient", name="ajouterClient")
     */
    public function ajouterClient(Request $request)
    {
        if (!empty($request->request->get('nom')) && 
            !empty($request->request->get('contact'))) {
            $nom=$request->request->get('nom');
            $contact=$request->request->get('contact');
            
            $client=new Client();
            $client->setNom($nom);
            $client->setContact($contact);
            $m=$this->getDoctrine()->getManager();
            $m->persist($client);
            $m->flush();
            return $this->json([
                'message'=>'Vos données ont été enregistrer avec success',
                'icon'=>'alert-success',
                'nom'=>$nom,
                'contact'=>$contact
            ]);
            
        }
        else {
            return $this->json([
                'message'=>'Votre formulaire ne doit pas etre vide... Remplissez-le',
                'icon'=>'alert-error'
            ]);
        }
    }
    /**
     * @Route("delete", name="deleteClient")
     */
    public function delete()
    {
        $c=$this->getDoctrine()->getConnection();
        $r=$c->exec('delete from client');
        return new Response('Données supprimés avec succès !');

    }
}
