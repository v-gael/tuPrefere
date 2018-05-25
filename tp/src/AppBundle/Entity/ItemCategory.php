<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * ItemCategory
 *
 * @ORM\Table(name="item_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemCategoryRepository")
 */
class ItemCategory
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
      * @Gedmo\Slug(fields={"titre"})
      * @ORM\Column(name="slug", type="string", length=255, unique=true)
      */
     private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="itemCategory")
    */
    private $items;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return ItemCategory
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    public function __toString()
    {
        return $this->titre.'';
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ItemCategory
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\Vote $item
     *
     * @return ItemCategory
     */
    public function addItem(\AppBundle\Entity\Vote $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\Vote $item
     */
    public function removeItem(\AppBundle\Entity\Vote $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return ItemCategory
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
