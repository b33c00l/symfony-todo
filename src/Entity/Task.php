<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{   
    const PRIORITY_LOW = 0;
    const PRIORITY_MEDIUM = 1;
    const PRIORITY_HIGH = 2;

    const STATUS_PENDING = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_DONE = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;
    
    /**
     * @ORM\Column(type="date")
     */
    private $deadline;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max = 300
     *)
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @Assert\Choice({0, 1, 2})
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @Assert\Choice({"High", "Medium", "Low"})
     */
    public function getPriorityString()
    {
        switch($this->getPriority()){
            case self::PRIORITY_HIGH;
                return 'High';
            case self::PRIORITY_MEDIUM;
                return 'Medium';
            case self::PRIORITY_LOW;
                return 'Low';
        }
    }

    /**
     * @Assert\Choice({1, 2, 3})
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @Assert\Choice({"Pending", "In progress", "Done"})
     */
    public function getStatusString()
    {
        switch($this->getStatus()){
            case self::STATUS_PENDING;
                return 'Pending';
            case self::STATUS_IN_PROGRESS;
                return 'In progress';
            case self::STATUS_DONE;
                return 'Done';
        }
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @Assert\Range(
     *     min = "+1 day"
     *)
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * @Assert\DateTime()
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }
}
