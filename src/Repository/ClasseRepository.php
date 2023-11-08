<?php

namespace App\Repository;

use App\Entity\Classe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classe>
 *
 * @method Classe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classe[]    findAll()
 * @method Classe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classe::class);
    }

    public function findPaginate($page,$limit) {
        return $this->createQueryBuilder('c')
            ->where('c.isActive = true')
            ->setFirstResult(($page-1)*$limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
     }

     public function findPaginateByFiltre($page,$limit,array $filtres) {

          $query=$this->createQueryBuilder('c')
                      ->where('c.isActive = true');
          if(!empty($filtres['filiere'])){
            $query= $query
                ->leftJoin('c.filiere','f')
                ->andWhere('f.id = :idFiliere')
                ->setParameter('idFiliere',$filtres['filiere']);
             }
            if(!empty($filtres['niveau'])){
                $query= $query
                ->leftJoin('c.niveau','n')
                ->andWhere('n.id = :idNiveau')
                ->setParameter('idNiveau',$filtres['niveau']);
         }
         return $query
               ->setFirstResult($page)
              ->setMaxResults($limit)
              ->getQuery()
              ->getResult();
     }

     public function countClasse() {
          return $this->createQueryBuilder('c')
                ->select('count(c.id) as count')
                ->where('c.isActive = true')
                ->getQuery()
                ->getSingleScalarResult();
      }

//    /**
//     * @return Classe[] Returns an array of Classe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Classe
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
