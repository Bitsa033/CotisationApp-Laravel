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
    
        return $this->render('ajax_et_symfony/index.html.twig', [
            'controller_name' => 'AjaxEtSymfonyController',
            'clients'=>$clientRepository->findAll()
        ]);
    }

    /**
     * @Route("traiter", name="app_traiter")
     */
    public function traiter(Request $request)
    {
        if (!empty($request->request->get('nom')) && !empty($request->request->get('contact'))) {
            $nom=$request->request->get('nom');
            $contact=$request->request->get('contact');
            //$age=$request->get('age');
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
                'message'=>'Votre formulaire ne doit pas est vide',
                'icon'=>'alert-error'
            ]);
        }
    }
    /**
     * @Route("afficher", name="app_afficher")
     */
    public function afficher(ClientRepository $clientRepository)
    {
        return $this->json([
            "client"=>$clientRepository->findAll()
        ]);
    }
}
