<?php
namespace App\Services;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Toto extends AbstractController{

  protected $table;
  protected $repo;
  protected $db;

  /**
   * Ce constructeur me donne automatiquement:
   * La connexion à la base de données
   * @param ManagerRegistry $manager
   */
  function __construct(ManagerRegistry $manager)
  {
    $this->db=$manager->getManager();
  }

  /**
   * Cette méthode affiche toutes les données d'une table
   * @return array
   */
  public function getAll():array
  {
    $fetchAll=$this->repo->findAll();

    return $fetchAll;

  }
  
  /**
   * Cette méthode affiche une donnée d'une table
   * par son id
   * @param integer $id
   * @return void
   */
  public function getOne(int $id)
  {
    $fetchOne =$this->repo->find($id);
    return $fetchOne;
  }

  /**
     * Cette méthode enregistre les données d'une table
     * @param $object
     * @return void
     */
    public function save($object)
    {
        $this->db->persist($object);
        $this->db->flush();
    }

    /**
     * Cette méthode supprime toutes les données d'une table
     * @return void
     */
    public function delete()
    {
      $alldata=$this->repo->findAll();
      foreach ($alldata as $key => $value) {
        $this->db->remove($value);
        $this->db->flush();
      }
    }

    /**
     * Cette méthode supprime une seule donnée d'une table 
     * par son id
     * @param int $id
     * @return void
     */
    public function deleteOne(int $id):void
    {
      $fid=$this->getOne($id);
      $this->db->remove($fid);
      $this->db->flush();
    }


}

  class Clients extends Toto
{

  /**
   * Je créé un constructeur qui me donne automatiquement:
   * la connexion à la base de données, le repository des clients
   * @param ManagerRegistry $manager
   * @param ClientRepository $clientRepository
   */
  function __construct(ManagerRegistry $manager,ClientRepository $clientRepository)
  {
    $this->table= new Client();
    $this->repo=$clientRepository;
    parent::__construct($manager);
  }

  /**
   * Cette méthode construit les données d'une table et les 
   * l'enregistre
   * @param array $data
   * @return void
   */
    public function create(array $data)
    {
      $table=$this->table;
      $table->setNom($data["nom"]);
      $table->setContact($data["contact"]);
       
        $this->save($table);
        return $table;
    }
        
    
}

