<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Cumts\MainBundle\Entity\Event
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="Cumts\MainBundle\Entity\EventRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="event_type", type="string")
 * @ORM\DiscriminatorMap({"show" = "Show", "bar_night" = "BarNight", "workshop" = "Workshop", "visit" = "Visit", "other" = "Event"})
 */
class Event
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    protected $slug;

    /**
     * @var datetime $start_at
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    protected $start_at;

    /**
     * @var datetime $end_at
     *
     * @ORM\Column(name="end_at", type="datetime")
     */
    protected $end_at;

    /**
     * @var text $summary
     *
     * @ORM\Column(name="summary", type="text")
     */
    protected $summary = "";

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text")
     */
    protected $body = "";

    /**
     * @var Image $image;
     * @ORM\ManyToOne(targetEntity="Hoyes\ImageManagerBundle\Entity\Image")
     */
    protected $image;

    /**
     * @var \DateTime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var \DateTime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updated_at;

    protected $event_type = 'other';

    protected $event_string = 'Event';

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
     * Set start_at
     *
     * @param datetime $startAt
     */
    public function setStartAt($startAt)
    {
        $this->start_at = $startAt;
    }

    /**
     * Get start_at
     *
     * @return datetime 
     */
    public function getStartAt()
    {
        return $this->start_at;
    }

    /**
     * Set end_at
     *
     * @param datetime $endAt
     */
    public function setEndAt($endAt)
    {
        $this->end_at = $endAt;
    }

    /**
     * Get end_at
     *
     * @return datetime 
     */
    public function getEndAt()
    {
        return $this->end_at;
    }

    /**
     * Set summary
     *
     * @param text $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * Get summary
     *
     * @return text 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set event_type
     *
     * @param smallint $eventType
     */
    public function setEventType($eventType)
    {
        $this->event_type = $eventType;
    }

    /**
     * Get event_type
     *
     * @return string
     */
    public function getEventType()
    {
        return $this->event_type;
    }

    public function getEventString()
    {
        return $this->event_string;
    }
    
   /** @ORM\PrePersist */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime;
        $this->updated_at = new \DateTime;
        $this->slug = '';
    }
    
    /** @ORM\PreUpdate */
    public function onPreUpdate()
    {
        $this->updated_at = new \DateTime;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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

    /**
     * Set title
     *
     * @param string $title
     * @return Event
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
     * Set image
     *
     * @param integer $image
     * @return Event
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Event
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
     * @return Event
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
}