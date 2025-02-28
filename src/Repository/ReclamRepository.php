<?php

namespace App\Repository;

use App\Entity\Reclam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reclam|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclam|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclam[]    findAll()
 * @method Reclam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclam::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Reclam $entity, bool $flush = true): void
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
    public function remove(Reclam $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Reclam[] Returns an array of Reclam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reclam
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function searchReclam($te,$tt)
    {
        $queryBuilder=$this->createQueryBuilder('search')->select('search')
            ->setParameter('value', '%'.$tt.'%');
            if($te == 'Etat'){
                $queryBuilder->where('search.etatrec LIKE :value');
            }else {
                $queryBuilder->where('search.idrec LIKE :value');
            }
            return $queryBuilder
            ->getQuery()
            ->getResult();
    }
    public function triReclam($type)
    {
        $queryBuilder=$this->createQueryBuilder('tri')->select('tri');
        if ($type == 'Etat'){
            $queryBuilder->orderBy('tri.etatrec', 'ASC');
        }else {
            $queryBuilder->orderBy('tri.typerec', 'ASC');
        }
          return  $queryBuilder->getQuery()->getResult();
    }
    public function findByTypeRec($typerec)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.typerec = :val')
            ->setParameter('val', $typerec)
            ->getQuery()
            ->getResult()
        ;
    }
}
