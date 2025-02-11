<?php

namespace App\Repository;

use DateTime;
use App\Entity\User;
use App\Entity\Carta;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Carta>
 */
class CartaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carta::class);
    }

    public function remove(Carta $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Carta[] Returns an array of Carta objects filtered by description and date range
     */
    public function findCartas(string $descripcion, string $fechaInicial, $fechaFinal): array
    {
        $qb = $this->createQueryBuilder('c');

        if (!empty($descripcion)) {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('c.descripcion', ':val'),
                    $qb->expr()->like('c.nombre', ':val')
                )
            )
                ->setParameter('val', '%' . $descripcion . '%');
        }

        if (!empty($fechaInicial)) {
            $dtFechaInicial = DateTime::createFromFormat('Y-m-d', $fechaInicial);
            $qb->andWhere($qb->expr()->gte('c.fechaAdicion', ':fechaInicial'))
                ->setParameter('fechaInicial', $dtFechaInicial);
        }

        if (!empty($fechaFinal)) {
            $dtFechaFinal = DateTime::createFromFormat('Y-m-d', $fechaFinal);
            $qb->andWhere($qb->expr()->lte('c.fechaAdicion', ':fechaFinal'))
                ->setParameter('fechaFinal', $dtFechaFinal);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Carta[] Returns an array of Carta objects sorted by a specified field
     */
    public function findCartasConOrdenacion(string $ordenacion, string $tipoOrdenacion): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.' . $ordenacion, $tipoOrdenacion)
            ->getQuery()
            ->getResult();
    }
}
