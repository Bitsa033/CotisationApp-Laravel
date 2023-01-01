<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AjaxEtSymfonyController extends AbstractController
{
    /**
     * @Route("/", name="app_ajax")
     */
    public function index(): Response
    {
    
        return $this->render('ajax_et_symfony/index.html.twig', [
            'controller_name' => 'AjaxEtSymfonyController',
        ]);
    }

    /**
     * @Route("traiter", name="app_traiter")
     */
    public function traiter(Request $request, SessionInterface $session)
    {
        $nom=$request->get('input');
        if (empty($nom)) {
            return new Response('Remplissez vos champs');
        }
        else {
            return new Response($nom);
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
