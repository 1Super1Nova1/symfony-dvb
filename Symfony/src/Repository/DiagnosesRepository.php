<?php

namespace App\Repository;

use App\Entity\Diagnoses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry; 
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator; 
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends ServiceEntityRepository<Diagnoses>
 */
class DiagnosesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Diagnoses::class);
    }

    /**
     * @param array $params
     * @param int $page
     * @param int $itemsPerPage
     * @return array
     */
    #[ArrayShape([
        'projects' => "mixed",
        'totalPageCount' => "float",
        'totalItems' => "int"
    ])] public function getDiagnoses(array $params = [], int $page = 1, int $itemsPerPage = 1): array
    {
        $queryBuilder = $this->createQueryBuilder('Diagnoses');

        $queryBuilder = $this->mapParams($queryBuilder, $params);

        $paginator = new Paginator($queryBuilder);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ((int) $page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'projects' => $paginator->getQuery()->getResult(),
            'totalPageCount' => $pagesCount,
            'totalItems' => $totalItems
        ];
    }

    private function mapParams(QueryBuilder $queryBuilder, array $params): QueryBuilder
    {
        foreach ($params as $key => $value) {

            $ourKey = $key;
            $ourValue = $value;

            if (is_array($value)) {
                $ourKey = $key . ucfirst(array_key_first($value));
                $ourValue = $value[array_key_first($value)];
            }

            $queryBuilder
                ->andWhere('Diagnoses.' . $key . ' LIKE :' . $ourKey)
                ->setParameter($ourKey, '%' . $ourValue . '%');
        }

        return $queryBuilder;
    }
}
