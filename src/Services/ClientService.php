<?php

namespace App\Services;

class ClientService extends DataBaseService implements ClientInterface
{

  /**
   * Cette méthode construit les données des tables [Client et Compte] et les 
   * enregistre
   * @param array $data
   * @return void
   */
  public function createData(array $data)
  {
    $table = $this->membreTable;
    $table->setNom($data["nom"]);
    $table->setAdresse($data["adresse"]);
    $table->setContact($data["contact"]);

    $c = $this->inscriptionTable;
    $c->setMembre($table);
    $c->setCreatedAt(new \dateTime());
    $this->save($c);
  }

  public function updateData(array $data)
  {
    $data['client']->setNom($data["nom"]);
    $data['client']->setContact($data["contact"]);
    $this->write();
  }

  public function findAllData()
  {
    return $this->inscriptionRepository->findAll();
  }

  public function deleteOneData($id)
  {
    $data= $this->inscriptionRepository->find($id);
    $this->db->remove($data);
  }
}
