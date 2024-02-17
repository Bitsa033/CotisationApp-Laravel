<?php

namespace App\Services;

class ClientService implements ClientInterface
{
    public $membreRepository;
    public $inscriptionRepository;
    // public $caisseRepository;
    // public $cotisationRepository;
    public $membreTable;
    public $inscriptionTable;
    public $dataBaseService;
    // public $cotisationTable;

  function __construct(DataBaseService $dataBaseService) {

    $this->dataBaseService=$dataBaseService;
     $this->membreRepository=$dataBaseService->membreRepository;
     $this->inscriptionRepository=$dataBaseService->inscriptionRepository;
     $this->membreTable=$dataBaseService->membreTable;
     $this->inscriptionTable=$dataBaseService->inscriptionTable;
  }

  /**
   * Cette méthode construit les données des tables [Client et Compte] et les 
   * enregistre
   * @param array $data
   * @return void
   */
  public function createData($nom,$contact,$adresse)
  {
    $table = $this->membreTable;
    $table->setNom($nom);
    $table->setContact($contact);
    $table->setAdresse($adresse);

    $c = $this->inscriptionTable;
    $c->setMembre($table);
    $c->setCreatedAt(new \dateTime());
    $this->dataBaseService->save($c);
    
  }

  public function updateData(array $data)
  {
    $data['client']->setNom($data["nom"]);
    $data['client']->setContact($data["contact"]);
    // $this->write();
  }

  public function findAllData()
  {
    return $this->inscriptionRepository->findAll();
  }

  public function findAOneData($id)
  {
    return $this->membreRepository->find($id);
  }

  public function deleteOneData($id)
  {
    $data= $this->inscriptionRepository->find($id);
    // $this->db->remove($data);
  }
}
