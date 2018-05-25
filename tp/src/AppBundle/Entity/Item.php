<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
class Item
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
     * @var int
     *
     * @ORM\Column(name="nbVote", type="integer")
     */
    private $nbVote=0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastVote", type="datetime", nullable=true)
     */
    private $lastVote;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=255, nullable=true)
     */
    private $content;
    /**
     * @var File
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png", "image/gif" })
     * @Vich\UploadableField(mapping="item_image", fileNameProperty="imageName")
     *
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;
    /**
     * @var string
     *
     * @ORM\Column(name="url_video", type="string", length=255, nullable=true)
     */
    private $urlVideo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
      * @ORM\ManyToOne(targetEntity="ItemCategory", inversedBy="items")
      * @ORM\JoinColumn(nullable=true)
     */
    private $itemCategory;

    /**
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="item")
     */
    private $votes;

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
     * @return Item
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

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Item
     */
    public function setImage($image)
    {
        $this->image = $image;

        if (null !== $image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->createdAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set urlVideo
     *
     * @param string $urlVideo
     *
     * @return Item
     */
    public function setUrlVideo($urlVideo)
    {
        $this->urlVideo = $urlVideo;

        return $this;
    }

    /**
     * Get urlVideo
     *
     * @return string
     */
    public function getUrlVideo()
    {
        return $this->urlVideo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Item
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
     * Set lastVote
     *
     * @param \DateTime $lastVote
     *
     * @return Item
     */
    public function setLastVote()
    {
        $this->lastVote = new \DateTime() ;

        return $this;
    }

    /**
     * Get lastVote
     *
     * @return \DateTime
     */
    public function getLastVote()
    {
        return $this->lastVote;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Item
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Item
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Item
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add vote
     *
     * @param \AppBundle\Entity\Vote $vote
     *
     * @return Item
     */
    public function addVote(\AppBundle\Entity\Vote $vote)
    {
        $this->votes[] = $vote;

        return $this;
    }

    /**
     * Remove vote
     *
     * @param \AppBundle\Entity\Vote $vote
     */
    public function removeVote(\AppBundle\Entity\Vote $vote)
    {
        $this->votes->removeElement($vote);
    }

    /**
     * Get votes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set itemCategory
     *
     * @param \AppBundle\Entity\ItemCategory $itemCategory
     *
     * @return Item
     */
    public function setItemCategory(\AppBundle\Entity\ItemCategory $itemCategory = null)
    {
        $this->itemCategory = $itemCategory;

        return $this;
    }

    /**
     * Get itemCategory
     *
     * @return \AppBundle\Entity\ItemCategory
     */
    public function getItemCategory()
    {
        return $this->itemCategory;
    }

    public function __toString()
    {
        return $this->titre.'';
    }

    public function getNbVote()
    {
      return $this->nbVote;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateNbVote()
    {
      $nbVote = 0;
      foreach ($this->votes as $vote) {
        $nbVote++;
      }
      $this->nbVote = $nbVote;
      return $this;
    }

    public function setNbVote($nbVote)
    {
      $this->nbVote = $nbVote;
      return $this;
    }
}
