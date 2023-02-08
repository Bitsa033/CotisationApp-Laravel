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
    public function createData($clients)
    {
      // $table= new $this->table;
      // $idClient=$this->getId($clients);
      // $table->setNumero(rand(100,9000));
      // $table->setSolde(0);
      // $table->setDateT(new \dateTime());
      // $table->setClient($clients);
      // $this->save($table);
    }

    public function depot(array $data,CompteRepository $repo)
    {
      $repo->deposer($data['compte'],$data['somme']);
      // $data['compte']->setSolde($data["somme"]);
      // $data['compte']->setDateT(new \datetime());
       
      // $this->update();
    }

    public function retrait(array $data,CompteRepository $repo)
    {
      $repo->retirer($data['compte'],$data['somme']);
      // $data['compte']->setSolde($data["somme"]);
      // $data['compte']->setDateT(new \datetime());
       
      // $this->update();
    }
        
    
}

