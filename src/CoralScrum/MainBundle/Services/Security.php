<?php

namespace CoralScrum\MainBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class Security {

    /**
     *
     * @var EntityManager 
     */
    protected $em;

    /**
     *
     * @var SecurityContextInterface 
     */
    protected $securityContext;

    public function __construct(EntityManager $entityManager, SecurityContextInterface $securityContext)
    {
        $this->em = $entityManager;
        $this->securityContext = $securityContext;
    }

    /**
     * Check if user belongs to the project.
     *
     */
    public function checkUserMembership($projectId)
    {
        $user = $this->securityContext->getToken()->getUser();
        if (!is_object($user)) {
            throw new AccessDeniedException('You are not logged in.');
        }

        $users = $this->em->getRepository('CoralScrumUserBundle:User')->findByProjectId($projectId);
        if (!in_array($user, $users)) {
            throw new AccessDeniedException('You do not have access to this page.');
        }

        return $user;
    }

    /**
     * Check if user has access to the project and if he can make changes.
     *
     */
    public function isGranted($projectId)
    {
        $project = $this->em->getRepository('CoralScrumMainBundle:Project')->find($projectId);
        if (!$project) {
            throw new AccessDeniedException('Unable to find Project entity.');
        }

        $isPublic = $project->getIsPublic();
        if ($isPublic) {
            // user can make changes only if he belongs to project
            $user = $this->securityContext->getToken()->getUser();
            if (!is_object($user)) {
                throw new AccessDeniedException('You are not logged in.');
            }

            $users = $this->em->getRepository('CoralScrumUserBundle:User')->findByProjectId($projectId);
            return in_array($user, $users);
        }
        else {
            // if he does not belong to the project, AccessDeniedException
            $this->checkUserMembership($projectId);
            return true;
        }
    }

    /**
     * Check if user is the creator of the project.
     *
     */
    public function isCreator($projectId)
    {
        $user = $this->securityContext->getToken()->getUser();
        if (!is_object($user)) {
            throw new AccessDeniedException('You are not logged in.');
        }

        $isCreator = $this->em->getRepository('CoralScrumMainBundle:Project')->isCreator($projectId, $user);
        if (!$isCreator) {
            throw new NotFoundHttpException('Only the project creator can access this page.');
        }

        return $user;
    }

    /**
     * Check if sprint is finished.
     *
     */
    public function isSprintFinished($sprintId)
    {
        $sprint = $this->em->getRepository('CoralScrumMainBundle:Sprint')->find($sprintId);
        if (!$sprint) {
            throw new NotFoundHttpException('Unable to find Sprint entity.');
        }

        $startDate = $sprint->getStartDate();
        $duration = $sprint->getDuration();

        $date = clone $startDate;
        $date->modify('+'.$duration.' days');
        $now = new \DateTime("now");

        if ($date > $now) {
            return false;
        }
        else {
            return true;
        }
    }
}