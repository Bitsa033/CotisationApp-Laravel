<?php
namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DataBaseService extends AbstractController{

    protected $table;
    protected $repo;
    protected $db;
  
    public function getConnect()
    {
      return $this->db= $this->getDoctrine()->getManager();
    }
  
    public function getRepo()
    {
      return $this->getDoctrine()->getRepository($this->table);
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
     * Cette méthode affiche l'id d'une table
     * @param integer $id
     * @return void
     */
    public function getId($id)
    {
      $repo=$this->repo=$this->getRepo();
      $fetchId =$repo->find($id);
      return $fetchId;
    }
  
      /**
       * Cette méthode supprime tous les enregistrements d'une table
       * @return void
       */
      public function deleteAll()
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
        $fid=$this->getId($id);
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
        $this->getConnect()->flush();
      }
  
  
  } 