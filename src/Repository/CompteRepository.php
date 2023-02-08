<?php

namespace App\Repository;

use App\Entity\Compte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Compte>
 *
 * @method Compte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compte[]    findAll()
 * @method Compte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compte::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Compte $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Compte $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // public function connection_to_databse(){

    //     try {
    //         $pdo=new \PDO('mysql:host=localhost;dbname=gnu','root','');
    //     } catch (Exception $th) {
    //         die( $th->getMessage());
    //     }

    //     return $pdo;
    // }

    public function deposer(Compte $compte,$somme)
    {
        $conn = $this->_em->getConnection();
        $sql = '
            update compte set solde = solde + :somme where id= :compte
        ';
        $stmt = $conn->prepare($sql);
        $stmt->executeQuery([
            'compte'=>$compte->getId(),
            'somme'=>$somme
        ]);

        //$resultat=$stmt->fetchAll();

        // returns an array of arrays (i.e. a raw data set)
        //return $resultat;
        
    }

    public function retirer(Compte $compte,$somme)
    {
        $conn = $this->_em->getConnection();
        $sql = '
            update compte set solde = solde - :somme where id= :compte
        ';
        $stmt = $conn->prepare($sql);
        $stmt->executeQuery([
            'compte'=>$compte->getId(),
            'somme'=>$somme
        ]);

        //$resultat=$stmt->fetchAll();

        // returns an array of arrays (i.e. a raw data set)
        //return $resultat;
        
    }

    // /**
    //  * @return Compte[] Returns an array of Compte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Compte
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
