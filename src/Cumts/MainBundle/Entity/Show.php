<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Criteria;

/**
 * Cumts\MainBundle\Entity\Show
 *
 * @ORM\Table(name="Shows")
 * @ORM\Entity(repositoryClass="Cumts\MainBundle\Entity\ShowRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Show
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $author
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string $venue
     *
     * @ORM\Column(name="venue", type="string", length=255)
     */
    private $venue;

    /**
     * @var \DateTime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var \DateTime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @var \DateTime $start_at
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    private $start_at;

    /**
     * @var \DateTime $end_at
     *
     * @ORM\Column(name="end_at", type="datetime")
     */
    private $end_at;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string $ticket_url
     *
     * @ORM\Column(name="ticket_url", type="string", length=255, nullable=true)
     */
    private $ticket_url;

    /**
     * @var integer $image
     *
     * @ORM\Column(name="image", type="integer", nullable=true)
     */
    private $image;
    
    /**
     * @var integer $camdram_id
     *
     * @ORM\Column(name="camdram_id", type="integer")
     */
    private $camdram_id;


    /**
     * @ORM\OneToMany(targetEntity="Performance", mappedBy="show")
     * @ORM\OrderBy({"start_at" = "ASC"})
     */
    private $performances;

    /**
     * @ORM\OneToMany(targetEntity="ShowRole", mappedBy="show")
     * @ORM\OrderBy({"role_type" = "ASC", "sort" = "ASC"})
     */    
    private $roles;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"camdram_id", "title"})
     */
    private $slug;
    

    public function __construct()
    {
        $this->performances = new ArrayCollection();
        $this->roles = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Shows
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set venue
     *
     * @param string $venue
     * @return Shows
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
    
        return $this;
    }

    /**
     * Get venue
     *
     * @return string 
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Shows
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    
        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Shows
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set start_at
     *
     * @param \DateTime $startAt
     * @return Shows
     */
    public function setStartAt($startAt)
    {
        $this->start_at = $startAt;
    
        return $this;
    }

    /**
     * Get start_at
     *
     * @return \DateTime 
     */
    public function getStartAt()
    {
        return $this->start_at;
    }

    /**
     * Set end_at
     *
     * @param \DateTime $endAt
     * @return Shows
     */
    public function setEndAt($endAt)
    {
        $this->end_at = $endAt;
    
        return $this;
    }

    /**
     * Get end_at
     *
     * @return \DateTime 
     */
    public function getEndAt()
    {
        return $this->end_at;
    }


    /**
     * Set ticket_url
     *
     * @param string $ticketUrl
     * @return Shows
     */
    public function setTicketUrl($ticketUrl)
    {
        $this->ticket_url = $ticketUrl;
    
        return $this;
    }

    /**
     * Get ticket_url
     *
     * @return string 
     */
    public function getTicketUrl()
    {
        return $this->ticket_url;
    }

    /**
     * Set image
     *
     * @param integer $image
     * @return Shows
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return integer 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set camdram_id
     *
     * @param integer $camdramId
     * @return Show
     */
    public function setCamdramId($camdramId)
    {
        $this->camdram_id = $camdramId;
    
        return $this;
    }

    /**
     * Get camdram_id
     *
     * @return integer 
     */
    public function getCamdramId()
    {
        return $this->camdram_id;
    }
    
    /** @ORM\PrePersist */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime;
        $this->updated_at = new \DateTime;
    }
    
    /** @ORM\PreUpdate */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTime;
    }

    /**
     * Add performances
     *
     * @param Cumts\MainBundle\Entity\Performance $performances
     * @return Show
     */
    public function addPerformance(\Cumts\MainBundle\Entity\Performance $performances)
    {
        $this->performances[] = $performances;
    
        return $this;
    }

    /**
     * Remove performances
     *
     * @param Cumts\MainBundle\Entity\Performance $performances
     */
    public function removePerformance(\Cumts\MainBundle\Entity\Performance $performances)
    {
        $this->performances->removeElement($performances);
    }

    /**
     * Get performances
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPerformances()
    {
        return $this->performances;
    }

    /**
     * Add roles
     *
     * @param Cumts\MainBundle\Entity\ShowRole $roles
     * @return Show
     */
    public function addRole(\Cumts\MainBundle\Entity\ShowRole $roles)
    {
        $this->roles[] = $roles;
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param Cumts\MainBundle\Entity\ShowRole $roles
     */
    public function removeRole(\Cumts\MainBundle\Entity\ShowRole $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Show
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
     * Set title
     *
     * @param string $title
     * @return Show
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
     * Set author
     *
     * @param string $author
     * @return Show
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Show
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

    protected function getRolesByType($type) {
         $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("role_type", $type))
            ->orderBy(array("sort" => "ASC"))
        ;

        return $this->getRoles()->matching($criteria);
    }

    public function getCast()
    {
        return $this->getRolesByType('cast');
    }

    public function getOrchestra()
    {
        return $this->getRolesByType('orchestra');
    }

    public function getProductionTeam()
    {
        return $this->getRolesByType('prod');
    }
}