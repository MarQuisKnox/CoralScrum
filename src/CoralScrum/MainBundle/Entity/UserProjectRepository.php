<?php

namespace CoralScrum\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserProjectRepository extends EntityRepository
{
    public function findByIdJoined($projectId)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT us_p, u FROM CoralScrumMainBundle:UserProject us_p
                LEFT JOIN us_p.user u
                JOIN us_p.project p
                WHERE p.id = :projectId'
            )->setParameter('projectId', $projectId);

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
