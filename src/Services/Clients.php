<?php
namespace App\Services;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

  class Clients extends AbstractController
{
  protected $db=null;
  protected $clients=null;

  function __construct(ManagerRegistry $manager,ClientRepository $clientRepository)
  {
    $this->db=$manager->getManager();
    $this->clients=$clientRepository;
    
  }
    public function create(array $data)
    {
       $client=new Client();
       $client->setNom($data["nom"]);
       $client->setContact($data["contact"]);
    
       return $client;
    }

    public function getAll()
    {
      $clients=$this->clients->findAll();

      return $clients;

    }

    public function save($object)
    {
        $this->db->persist($object);
        $this->db->flush();
    }

    public function delete(Client $id)
    {
      $this->clients->remove($id);
    }
    
}

