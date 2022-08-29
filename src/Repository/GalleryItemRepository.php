<?php

namespace App\Repository;

use App\Entity\Gallery;
use App\Entity\GalleryItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GalleryItem>
 *
 * @method GalleryItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryItem[]    findAll()
 * @method GalleryItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalleryItem::class);
    }

    public function add(GalleryItem $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GalleryItem $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function listOfGalleryItems(): array
    {
        return $this->findAll();
    }

//    /**
//     * @return GalleryItem[] Returns an array of GalleryItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GalleryItem
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
