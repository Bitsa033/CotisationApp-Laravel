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

    public function depot(array $data)
    {
      $this->repo->deposer($data['compte'],$data['somme']);
    }

    public function retrait(array $data)
    {
      $this->repo->retirer($data['id_compte'],$data['somme']);
       
    }
        
    
}

