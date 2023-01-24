<?php
namespace App\Services;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

  class Clients extends AbstractController
{
  /**
   * Je créé les variables protégés: $db et $clients
   * $db:pour la base de données
   * $clients:pour le repository des clients
   */
  protected $db=null;
  protected $clients=null;

  /**
   * Je créé un constructeur qui me donne automatiquement:
   * la connexion à la base de données, le repository des clients
   * @param ManagerRegistry $manager
   * @param ClientRepository $clientRepository
   */
  function __construct(ManagerRegistry $manager,ClientRepository $clientRepository)
  {
    $this->db=$manager->getManager();
    $this->clients=$clientRepository;
  }

  /**
     * Cette fonction enregistre un objet de type client en
     * base de données
     * @param Client $object
     * @return void
     */
    public function save(Client $object)
    {
        $this->db->persist($object);
        $this->db->flush();
    }

  /**
   * Cette fonction crée un nouveau client et
   * l'enregistre en base de données
   * @param array $data
   * @return void
   */
    public function create(array $data)
    {
       $client=new Client();
       $client->setNom($data["nom"]);
       $client->setContact($data["contact"]);
       
        $this->save($client);
        return $client;
    }
    
    /**
     * Cette fonction affiche tous les clients qui
     * sont en base de données
     * @return void
     */
    public function getAll()
    {
      $clients=$this->clients->findAll();

      return $clients;

    }

    /**
     * Cette fonction supprime tous les
     * clients qui se trouvent en base de
     * données
     * @return void
     */
    public function delete()
    {
      $allclient=$this->clients->findAll();
      foreach ($allclient as $key => $value) {
        $this->db->remove($value);
        $this->db->flush();
      }
      //dd($allclient);
    }

    public function deleteOne($id)
    {
      $clientid=$this->clients->find($id);
      $this->db->remove($clientid);
      $this->db->flush();
    }

    
}

