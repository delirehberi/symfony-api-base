<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 6.02.2016
 * Time: 02:21
 */

namespace CrudBundle\Entity;


use Doctrine\ORM\EntityRepository;

abstract class CrudRepository extends EntityRepository
{
    /**
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOneById($id)
    {
        $qb = $this->createQueryBuilder("o");
        $qb->where(
            $qb->expr()->eq('o.id', ':id')
        )
            ->setParameter('id', $id);
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param int $offset
     * @param null $limit
     * @return array
     */
    public function getAll($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder("o");
        if ($limit) {
            $qb->setMaxResults($limit)
                ->setFirstResult($limit * $offset);
        }
        return $qb->getQuery()->getResult();
    }

}