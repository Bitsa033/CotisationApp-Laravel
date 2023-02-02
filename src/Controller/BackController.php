<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use App\Services\C2;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * @Route("/back", name="compte_index")
     */
    public function index(C2 $compte): Response
    {
        return $this->render('back/index.html.twig', [
            'comptes' => $compte->getAll(),
        ]);
    }
}
