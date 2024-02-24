<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Cotisation;
use App\Services\ClientService;
use App\Services\CompteService;
use App\Services\DataBaseService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends CompteService
{

    /**
     * lien pour afficher tous les comptes
     * @Route("caisses", name="caisses")
     */
    function listeCaisses(DataBaseService $dataBaseService): Response
    {
        return $this->render("compte/listeCaisses.html.twig", [
            'caisses' => $dataBaseService->caisseRepository->findAll()
        ]);
    }

    /**
     * lien pour afficher tous les comptes
     * @Route("cotisations", name="cotisations")
     */
    function listeCotisations(DataBaseService $dataBaseService): Response
    {
        return $this->render("compte/listeCotisations.html.twig", [
            'caisses' => $dataBaseService->cotisationRepository->findAll()
        ]);
    }

    /**
     * lien pour créer une nouvelle caisse
     * @Route("nouvelleCaisse", name="nouvelleCaisse")
     */
    function nouvelleCaisse(): Response
    {
        return $this->render("compte/nouvelleCaisse.html.twig", []);
    }

    /**
     * lien pour créer un nouveau uncompte
     * @Route("nouveauCompte", name="nouveauCompte")
     */
    function nouveauCompte(): Response
    {
        return $this->render("compte/nouveauCompte.html.twig", []);
    }

    /**
     * lien pour crediter un compte
     * @Route("crediterCompte", name="crediterCompte")
     */
    function crediterCompte(Request $request, DataBaseService $dataBaseService, SessionInterface $sessionInterface): Response
    {
        $get_id_compte_courant = $request->query->get("id");
        $sessionInterface->set("id_compte_courant", $get_id_compte_courant);

        return $this->render("compte/crediterCompte.html.twig", [
            'caisses' => $dataBaseService->caisseRepository->findAll(),
            'inscriptions' => $dataBaseService->inscriptionRepository->findAll()
        ]);
    }

    /**
     * lien pour debiter un compte
     * @Route("debiterCompte", name="debiterCompte")
     */
    function debiterCompte(Request $request, SessionInterface $sessionInterface, DataBaseService $dataBaseService): Response
    {
        $get_id_compte_courant = $request->query->get("id");
        $sessionInterface->set("id_compte_courant", $get_id_compte_courant);

        return $this->render("compte/debiterCompte.html.twig", [
            'inscriptions' => $dataBaseService->inscriptionRepository->findAll()
        ]);
    }

    /**
     * lien pour transferer de l'argent
     * @Route("transfererArgent", name="transfererArgent")
     */
    function transfererArgent(Request $request, SessionInterface $sessionInterface, DataBaseService $dataBaseService): Response
    {
        $get_id_compte_courant = $request->query->get("id");
        $sessionInterface->set("id_compte_courant", $get_id_compte_courant);

        return $this->render("compte/transfererMontant.html.twig", [
            'inscriptions' => $dataBaseService->inscriptionRepository->findAll()
        ]);
    }

    /**
     * lien pour enregistrer un nouveau compte
     * @Route("nouveauCompteB", name="nouveauCompteB")
     */
    public function nouveauCompteB(Request $request, DataBaseService $dataBaseService)
    {
        $nom = $request->request->get('nom');
        $adresse = $request->request->get('adresse');
        $contact = $request->request->get('contact');
        if (!empty($nom) && !empty($contact)) {
            $membre = $dataBaseService->membreTable;
            $membre->setNom($nom);
            $membre->setContact($contact);
            $membre->setAdresse($adresse);
            $inscription = $dataBaseService->inscriptionTable;
            $inscription->setMembre($membre);
            $inscription->setCreatedAt(new \DateTime());
            $dataBaseService->save($inscription);
            $this->addFlash('success', 'Caisse crée avec succès !');
            return $this->redirect('membres');
        } else {
            $this->addFlash('erreur', 'Remplissez votre formulaire, ne laissez aucun vide !');
            return $this->redirect('nouveauCompte');
        }
    }

    /**
     * lien pour enregistrer un nouveau compte
     * @Route("nouvelleCaisseB", name="nouvelleCaisseB")
     */
    public function nouvelleCaisseB(Request $request, DataBaseService $service)
    {
        $nom = $request->request->get('nom');
        $code = $request->request->get('code');
        if (!empty($nom) && !empty($code)) {
            $caisse = $service->caisseTable;
            $caisse->setNom($nom);
            $caisse->setCode($code);
            $service->save($caisse);
            $this->addFlash('success', 'Caisse crée avec succès !');
            return $this->redirectToRoute('caisses');
        } else {
            $this->addFlash('erreur', 'Remplissez votre formulaire, ne laissez aucun vide !');
            return $this->redirect('nouveauCompte');
        }
    }


    /**
     * lien pour crediter un compte
     * @Route("crediterCompteB", name="crediterCompteB")
     */
    function crediterCompteB(Request $request, DataBaseService $dataBaseService, SessionInterface $sessionInterface)
    {
        $id_compte_courant = $sessionInterface->get("id_compte_courant");
        $membre = $dataBaseService->inscriptionRepository->find($id_compte_courant);
        // $current_membre=$dataBaseService->cotisationRepository->findCotisations($dataBaseService);

        $size_of_form = sizeof($request->request);
        for ($i = 1; $i <= $size_of_form; $i++) {
            $name_of_form = $request->request->get("montant{$i}");
            $caisse = $dataBaseService->caisseRepository->find($i);
            $cotisation = $dataBaseService->cotisationRepository->findBy([
                'caisse' => $caisse,
                'inscription' => $membre,
                'created_at' => new \DateTime()
            ]);
            $compte = $dataBaseService->compteRepository->findBy([
                'caisse' => $caisse,
                'inscription' => $membre,
            ]);

            if (!$cotisation) {
                // dd('vide');
                $cotisation = new Cotisation();
                $cotisation->setInscription($membre);
                $cotisation->setCaisse($caisse);
                $cotisation->setMontant($name_of_form);
                $cotisation->setCreatedAt(new \DateTime());
                $dataBaseService->save($cotisation);
            } 
            elseif (!$compte) {
                $compte = new Compte();
                $compte->setCaisse($caisse);
                $compte->setInscription($membre);
                $compte->setSolde($name_of_form);
            }
            else {
                // dd($caisse_date);
                foreach ($cotisation as $key => $value) {
                    $cmontant_courant = $value->getMontant();
                    $montant_actuel = $cmontant_courant + $name_of_form;
                    $value->setMontant($montant_actuel);
                    $dataBaseService->db->flush();
                }

                foreach ($compte as $key => $value) {
                    $solde_courant=$value->getSolde();
                    $solde_actuel=$solde_courant + $name_of_form;
                    $value->setSolde($solde_actuel);
                    $dataBaseService->db->flush();
                }
            }
        }

        $this->addFlash('success', "Dépot éffectué");
        return $this->redirectToRoute("crediterCompte");
        // return new Response();
    }

    /**
     * lien pour débiter un compte
     * @Route("debiterCompteB", name="debiterCompteB")
     */
    function debiterCompteB(
        Request $request,
        BackController $backController,
        SessionInterface $sessionInterface,
        DataBaseService $dataBaseService
    ) {
        $id_compte_courant = $sessionInterface->get("id_compte_courant");
        $post_montant = $request->request->get('montant');

        $backController->retraitCompte($id_compte_courant, $post_montant, $dataBaseService);
        $this->addFlash('success', "Retrait éffectué");
        return $this->redirect("membres");
    }


    /**
     * lien pour transferer de l'argent d 'un compte à un autre
     * @Route("transfererArgentB", name="transfererArgentB")
     */
    function transfererArgentB(
        Request $request,
        BackController $backController,
        Session $sessionInterface,
        DataBaseService $dataBaseService
    ) {
        $backController->virerArgent($request, $sessionInterface, $dataBaseService);

        $this->addFlash('success', "Transfert éffectué");
        return $this->redirect("membres");
    }
}
