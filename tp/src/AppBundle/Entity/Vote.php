<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Vote
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * Get id
    *
    * @return int
    */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="votes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    // choix de l'utilisateur
    /**
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="votes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    /**
      *
      * @ORM\PrePersist
      * @ORM\PreUpdate
      */
    public function updatedTimestamps()
    {
       if ($this->getDateCreated() == null) {
           $this->setDateCreated(new \DateTime('now'));
       }
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Vote
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Vote
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set item
     *
     * @param \AppBundle\Entity\Item $item
     *
     * @return Vote
     */
    public function setItem(\AppBundle\Entity\Item $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \AppBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }
}
