<?php

namespace App\Services;

use App\Entity\Client;
use App\Entity\Compte;

class ClientService extends CompteService
{

  public function __construct()
  {
    $this->table = Client::class;
  }

  /**
   * Cette méthode construit les données des tables [Client et Compte] et les 
   * enregistre
   * @param array $data
   * @return void
   */
  public function createData(array $data)
  {
    $table = new $this->table;
    $table->setNom($data["nom"]);
    $table->setContact($data["contact"]);

    $c = new Compte();
    $c->setNumero(rand(100, 9000));
    $c->setSolde(0);
    $c->setDateT(new \dateTime());
    $c->setClient($table);
    $this->save($c);
  }

  public function updateData(array $data)
  {
    $data['client']->setNom($data["nom"]);
    $data['client']->setContact($data["contact"]);
    $this->update();
  }
}
