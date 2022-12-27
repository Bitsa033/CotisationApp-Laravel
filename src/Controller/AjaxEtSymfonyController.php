<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function valider(Request $request)
    {
        $input=$request->get('input');
        //dd($input);
        if (isset($input) && !empty($input)) {
            return $this->json([
                "message"=>"Vous avez validé le formulaire"
            ]);
        }
        else {
            return $this->json([
                "message"=>"Votre formulaire est vide"
            ]);
        }
        
    }
}
