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

  public function getConnect()
  {
    return $this->db= $this->getDoctrine()->getManager();
  }

  public function getRepo()
  {
    return $this->db= $this->getDoctrine()->getRepository($this->table);
  }

  /**
   * Cette méthode affiche tous les enregistrements d'une table
   * @return array
   */
  public function getAll():array
  {
    $repo=$this->repo=$this->getRepo();
    $fetchAll=$repo->findAll();

    return $fetchAll;

  }
  
  /**
   * Cette méthode affiche un enregistrement d'une table
   * par son id
   * @param integer $id
   * @return void
   */
  public function getOne(int $id)
  {
    $repo=$this->repo=$this->getRepo();
    $fetchOne =$repo->find($id);
    return $fetchOne;
  }

    /**
     * Cette méthode supprime tous les enregistrements d'une table
     * @return void
     */
    public function delete()
    {
      $this->db=$this->getConnect();
      $this->repo=$this->getRepo();
      $alldata=$this->repo->findAll();
      foreach ($alldata as $key => $value) {
        $this->db->remove($value);
        //$this->db->flush();
      }
    }

    /**
     * Cette méthode supprime un seul enregistrement d'une table 
     * par son id
     * @param int $id
     * @return void
     */
    public function deleteOne(int $id):void
    {
      $this->db=$this->getConnect();
      $fid=$this->getOne($id);
      $this->db->remove($fid);
      //$this->db->flush();
    }

    /**
     * Cette méthode enregistre les données d'une table
     * @param $object
     * @return void
     */
    public function save($object)
    {
      $this->db=$this->getConnect();
      $this->db->persist($object);
      $this->db->flush();
    }

    /**
     * Cette méthode modifie les données d'une table par son id
     * @param $object
     * @return void
     */
    public function update()
    {
      $this->db=$this->getConnect();
      $this->db->flush();
    }


}

  class Clients extends Toto
{

  public function __construct(ClientRepository $repo)
  {
    $this->table= Client::class;
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

