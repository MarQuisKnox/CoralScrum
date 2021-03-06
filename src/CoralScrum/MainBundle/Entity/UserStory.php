<?php

namespace CoralScrum\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStory
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="userStoryId_uc", columns={"project_id", "displayId"})})
 * @ORM\Entity(repositoryClass="CoralScrum\MainBundle\Entity\UserStoryRepository")
 */
class UserStory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Integer
     *
     * @ORM\Column(name="displayId", type="integer")
     */
    private $displayId;

    /**
     * @var Project $project
     *
     * @ORM\ManyToOne(targetEntity="CoralScrum\MainBundle\Entity\Project", inversedBy="userStory")
     */
    private $project;

    /**
     * @ORM\ManyToMany(targetEntity="CoralScrum\MainBundle\Entity\Sprint", mappedBy="userStory")
     **/
    private $sprint;

    /**
     * @ORM\OneToMany(targetEntity="CoralScrum\MainBundle\Entity\Test", mappedBy="userStory", cascade={"remove"})
     **/
    private $test;

    /**
     * @ORM\OneToMany(targetEntity="CoralScrum\MainBundle\Entity\Task", mappedBy="userStory", cascade={"remove"})
     **/
    private $task;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

    /**
     * @var integer
     *
     * @ORM\Column(name="difficulty", type="integer")
     */
    private $difficulty;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isFinished", type="boolean")
     */
    private $isFinished;


    /**
     * 0 : no tests
     * 1 : validated (all tests ok)
     * 2 : not validated
     *
     * @var integer
     *
     * @ORM\Column(name="validated", type="integer")
     */
    private $validated;


    public function __toString()
    {
        return "#".$this->displayId.": ".$this->title;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set displayId
     *
     * @param integer $displayId
     * @return UserStory
     */
    public function setDisplayId($displayId)
    {
        $this->displayId = $displayId;
    
        return $this;
    }

    /**
     * Get displayId
     *
     * @return integer 
     */
    public function getDisplayId()
    {
        return $this->displayId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return UserStory
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return UserStory
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return UserStory
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    
        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set difficulty
     *
     * @param integer $difficulty
     * @return UserStory
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;
    
        return $this;
    }

    /**
     * Get difficulty
     *
     * @return integer 
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set isFinished
     *
     * @param boolean $isFinished
     * @return UserStory
     */
    public function setIsFinished($isFinished)
    {
        $this->isFinished = $isFinished;
    
        return $this;
    }

    /**
     * Get isFinished
     *
     * @return boolean 
     */
    public function getIsFinished()
    {
        return $this->isFinished;
    }

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return UserStory
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
    
        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sprint = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isFinished = false;
        $this->validated = 0;
    }

    /**
     * Set project
     *
     * @param \CoralScrum\MainBundle\Entity\Project $project
     * @return UserStory
     */
    public function setProject(\CoralScrum\MainBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return \CoralScrum\MainBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add sprint
     *
     * @param \CoralScrum\MainBundle\Entity\Sprint $sprint
     * @return UserStory
     */
    public function addSprint(\CoralScrum\MainBundle\Entity\Sprint $sprint)
    {
        $this->sprint[] = $sprint;
    
        return $this;
    }

    /**
     * Remove sprint
     *
     * @param \CoralScrum\MainBundle\Entity\Sprint $sprint
     */
    public function removeSprint(\CoralScrum\MainBundle\Entity\Sprint $sprint)
    {
        $this->sprint->removeElement($sprint);
    }

    /**
     * Get sprint
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSprint()
    {
        return $this->sprint;
    }

    /**
     * Add test
     *
     * @param \CoralScrum\MainBundle\Entity\Test $test
     * @return UserStory
     */
    public function addTest(\CoralScrum\MainBundle\Entity\Test $test)
    {
        $this->test[] = $test;
    
        return $this;
    }

    /**
     * Remove test
     *
     * @param \CoralScrum\MainBundle\Entity\Test $test
     */
    public function removeTest(\CoralScrum\MainBundle\Entity\Test $test)
    {
        $this->test->removeElement($test);
    }

    /**
     * Get test
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Add task
     *
     * @param \CoralScrum\MainBundle\Entity\Task $task
     * @return UserStory
     */
    public function addTask(\CoralScrum\MainBundle\Entity\Task $task)
    {
        $this->task[] = $task;
    
        return $this;
    }

    /**
     * Remove task
     *
     * @param \CoralScrum\MainBundle\Entity\Task $task
     */
    public function removeTask(\CoralScrum\MainBundle\Entity\Task $task)
    {
        $this->task->removeElement($task);
    }

    /**
     * Get task
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTask()
    {
        return $this->task;
    }
}