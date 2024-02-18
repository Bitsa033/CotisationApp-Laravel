<?php

namespace App\Repository;

use App\Entity\Cotisation;
use App\Services\DataBaseService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cotisation>
 *
 * @method Cotisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cotisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cotisation[]    findAll()
 * @method Cotisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CotisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cotisation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Cotisation $entity, bool $flush = true): void
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
    public function remove(Cotisation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Cotisation[] Returns an array of Cotisation objects
    //  */
    
    public function findCotisations(DataBaseService $dataBaseService)
    {
        $conn = $dataBaseService->con_with_pdo_to_mysql();
        $sql = '
        SELECT membre.nom as membre, caisse.nom as caisse, cotisation.montant FROM cotisation inner join inscription ON
        inscription.id=cotisation.inscription_id inner join membre on membre.id = 
        inscription.membre_id inner join caisse on caisse.id= cotisation.caisse_id
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultat=$stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)
        return $resultat;
        
    }
    

    /*
    public function findOneBySomeField($value): ?Cotisation
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
