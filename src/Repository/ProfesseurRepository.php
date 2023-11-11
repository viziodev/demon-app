<?php

namespace App\Repository;

use App\Entity\Professeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Professeur>
 *
 * @method Professeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professeur[]    findAll()
 * @method Professeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professeur::class);
    }

   /**
    * @return Professeur[] Returns an array of Professeur objects
    */
   public function findDistinctGrade(): array
   {  
           $entityManager = $this->getEntityManager();
           $query = $entityManager->createQuery(
            'SELECT p.grade
               FROM App\Entity\Professeur p
              ORDER BY p.grade ASC'
             );

        // returns an array of Product objects
       // dd( array_map(fn($value):string => $value['grade'] ,$query->getResult()))  ;
           return $query->getResult();
   }

//    public function findOneBySomeField($value): ?Professeur
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
