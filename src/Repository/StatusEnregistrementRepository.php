<?php

namespace App\Repository;

use App\Entity\StatusEnregistrement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatusEnregistrement>
 *
 * @method StatusEnregistrement|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusEnregistrement|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusEnregistrement[]    findAll()
 * @method StatusEnregistrement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusEnregistrementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusEnregistrement::class);
    }

    public function save(StatusEnregistrement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StatusEnregistrement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StatusEnregistrement[] Returns an array of StatusEnregistrement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StatusEnregistrement
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
