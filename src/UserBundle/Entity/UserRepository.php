<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 6.02.2016
 * Time: 00:32
 */

namespace UserBundle\Entity;

use CrudBundle\Entity\CrudRepository;

class UserRepository extends CrudRepository
{
    /**
     * @param $username
     * @return User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUser($username)
    {
        $qb = $this->createQueryBuilder("u");
        $qb->where(
            $qb->expr()->eq("u.email", ':username')
        )
            ->setParameter('username', $username);

        return $qb->getQuery()->getOneOrNullResult();
    }
}