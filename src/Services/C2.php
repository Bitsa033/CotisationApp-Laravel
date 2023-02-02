<?php
namespace App\Services;
use App\Entity\Compte;
use App\Repository\CompteRepository;

class C2 extends Toto
{

  public function __construct(CompteRepository $repo)
  {
    $this->table= Compte::class;
    $this->repo=$repo;
  }

  /**
   * Cette méthode construit les données d'une table et les 
   * l'enregistre
   * @param array $data
   * @return void
   */
    public function create(array $data)
    {
      $table= new $this->table;
      $table->setNom($data["nom"]);
      $table->setContact($data["contact"]);
       
      $this->save($table);
    }

    public function updateClient(array $data)
    {
      $data['client']->setNom($data["nom"]);
      $data['client']->setContact($data["contact"]);
       
      $this->update();
    }
        
    
}

