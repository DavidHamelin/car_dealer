<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\CarSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Car $entity, bool $flush = true): void
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
    public function remove(Car $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */
    public function findByOptions(CarSearch $carSearch)
    {
        // dd($carSearch->getEnergyOption());

        $query = $this->createQueryBuilder('c');
        if ($carSearch->getEnergyOption()) {
            $i = 0;
            foreach ($carSearch->getEnergyOption() as $option) {
                $query = $query->andWhere(":valEnergy$i MEMBER OF c.energyOptions")->setParameter("valEnergy$i", $option);
                $i++;
            }
        }
        if ($carSearch->getSeat()) {
            $j = 0;
            foreach ($carSearch->getSeat() as $seat) {
                $query = $query->andWhere("c.seat IN (:valSeat$j)")->setParameter("valSeat$j", $seat);
                $j++;
            }
        }
        if ($carSearch->getKm()) {
            $query = $query->andWhere("c.km <= :valKm")->setParameter("valKm", $carSearch->getKm());
        }

        // :val MEMBER OF c.table si utilisation d'un tableau de collections

        return $query->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Car
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
