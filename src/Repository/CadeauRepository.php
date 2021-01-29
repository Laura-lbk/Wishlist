<?php

namespace App\Repository;

use App\Entity\Cadeau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cadeau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cadeau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cadeau[]    findAll()
 * @method Cadeau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadeauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cadeau::class);
    }

    public function findbyGenre($nom, $genre){
        return $this->createQueryBuilder('c')
        ->leftJoin('c.categorie', 'categorie')
        ->leftJoin('c.personne', 'personne')
        ->where('categorie.nom = :val')
        ->andWhere('personne.sexe = :genre')
        ->setParameter('val', $nom)
        ->setParameter('genre', $genre)
        ->select('count(c)')
        ->getQuery()
        ->getSingleScalarResult();
    ;
    }


    // /**
    //  * @return Cadeau[] Returns an array of Cadeau objects
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
    public function findOneBySomeField($value): ?Cadeau
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
