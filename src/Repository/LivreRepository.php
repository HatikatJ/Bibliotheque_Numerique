<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function save(Livre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Livre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Livre[] Returns an array of Livre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Livre
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }









// LIVRE LES PLUS LU : app_accueil VIEW
// public function livresPlusLus()
//     {
//         $entityManager = $this->getDoctrine()->getManager();

//         $query = "
//             SELECT l.titre, COUNT(ll.id) AS nb_lectures
//             FROM livre l
//             JOIN livre_lecteur ll ON l.id = ll.livre_id
//             GROUP BY l.id
//             ORDER BY nb_lectures DESC
//             LIMIT 10
//         ";

//         $stmt = $entityManager->getConnection()->prepare($query);
//         $stmt->execute();
//         $result = $stmt->fetchAll();

//         return $this->render('livre/livres_plus_lus.html.twig', [
//             'livres' => $result,
//         ]);
//     }




// LIVRE LES PLUS LU : app_accueil VIEW
// public function findMostReadBooks(int $limit = 4): array
// {
//     return $this->createQueryBuilder('livre')
//         ->select('livre.image_couverture, COUNT(livre_lecteur.livre_id) AS nbLecteurs')
//         ->join('livre_lecteur', 'livre', 'livre.id=livre_lecteur.livre_id')
//         ->groupBy('livre.id')
//         ->orderBy('nbLecteurs', 'DESC')
//         ->setMaxResults($limit)
//         ->getQuery()
//         ->getResult();
// }

// public function findByNombreDeLecteurs(int $limit = 4): array
// {
//     return $this->createQueryBuilder('Livre')
//         ->leftJoin('Livre.utilisateurlecteur', 'u')
//         ->addSelect('COUNT(u) as nombreDeLecteurs')
//         ->groupBy('Livre')
//         ->orderBy('nombreDeLecteurs', 'DESC')
//         ->setMaxResults($limit)
//         ->getQuery()
//         ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
// }




public function findAllGenre()
{
    $genres = $this->createQueryBuilder('l')
        ->select('DISTINCT l.genre')
        ->getQuery()
        ->getResult();

    return array_column($genres, 'genre');
}


// public function findByGenre($genre)
// {
//     return $this->createQueryBuilder('l')
//         ->andWhere('l.genre = :genre')
//         ->setParameter('genre', $genre)
//         ->getQuery()
//         ->getResult();
// }



}
