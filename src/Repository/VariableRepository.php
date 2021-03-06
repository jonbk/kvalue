<?php

namespace App\Repository;

use App\Entity\Variable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Variable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Variable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Variable[]    findAll()
 * @method Variable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Variable::class);
    }

    public function save(Variable $variable):void
    {
        $this->_em->persist($variable);
        $this->_em->flush();
    }
}
