<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\Query\Expr\Join as ExprJoin;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @return Property[] Returns an array of Property objects
     */

    public function Search($startDate = "", $endDate = "", $capacity = "", $priceMax = "", $priceMin = "", $type = "", $city = "", $order = "ASC")
    {
        $adresse = "";
        $reservation = "";
        $disponibility = "";

        return $this->createQueryBuilder('p')
            ->select("SELECT * FROM property as p
        WHERE 
        p.property_type_id in (SELECT id FROM property_type WHERE property_type.title = :type OR NOT NULL)
        OR
        p.addresse_id in (SELECT id FROM addresse WHERE addresse.city = :city OR NOT NULL)
        OR
        p.id in 
        (
            SELECT reservation.reserved_property_id FROM reservation 
             WHERE
            reservation.start_date > :startDate OR NOT NULL AND reservation.start_date > :startDate OR NOT NULL
            AND
            reservation.end_date > :endDate OR NOT NULL AND reservation.end_date > :endDate OR NOT NULL
            AND
            reservation.start_date < :startDate OR NOT NULL AND reservation.start_date < :startDate OR NOT NULL
            AND
            reservation.end_date < :endDate OR NOT NULL AND reservation.end_date < :endDate OR NOT NULL
        );")
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('city', $city)
            /* ->setParameter('capacity', $capacity)
            ->setParameter('priceMax', $priceMax)
            ->setParameter('priceMin', $priceMin) */
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
        /* return $this->createQueryBuilder('p')
            ->join('App\Entity\Addresse', 'ad')
            ->andWhere('p.addresse = ad.id')
            ->join('App\Entity\PropertyType', 'type')
            ->andWhere('p.propertyType = type.id')
            ->join('App\Entity\Reservation', 'booked')
            ->andWhere('p.id = booked.reserved_property')
            ->orWhere('booked.start_date >= :startDate')
            ->orWhere('booked.start_date >= :endDate')
            ->orWhere('booked.end_date <= :startDate')
            ->orWhere('booked.end_date <= :endDate')
            ->orWhere('ad.city = :city')
            ->orWhere('p.capacity = :capacity')
            ->orWhere('p.price >= :priceMin')
            ->orWhere('p.price <= :priceMax')
            ->orWhere('type.title LIKE :type')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('city', $city)
            ->setParameter('capacity', $capacity)
            ->setParameter('priceMax', $priceMax)
            ->setParameter('priceMin', $priceMin)
            ->setParameter('type', '%' . $type . '%')
            ->orderBy('p.price', $order)
            ->getQuery()
            ->getResult(); */
    }


    public function findAsArray($value): ?array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $value)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Property[] Returns an array of Property objects
     */

    public function findLastThree()
    {
        return $this
            ->createQueryBuilder("p")
            ->where("p.addresse IS NOT NULL")
            ->orderBy("p.id", "DESC")
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
