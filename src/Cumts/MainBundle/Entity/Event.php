<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Cumts\MainBundle\Entity\Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cumts\MainBundle\Entity\EventRepository")
 * @ORM\HasLifecycleCallbacks
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
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @var datetime $start_at
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    private $start_at;

    /**
     * @var datetime $end_at
     *
     * @ORM\Column(name="end_at", type="datetime")
     */
    private $end_at;

    /**
     * @var text $summary
     *
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var smallint $event_type
     *
     * @ORM\Column(name="event_type", type="smallint")
     */
    private $event_type;


    const TYPE_SHOW = 0;
    const TYPE_BAR_NIGHT = 1;
    const TYPE_VISIT = 2;
    const TYPE_WORKSHOP = 3;

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
     * @return smallint 
     */
    public function getEventType()
    {
        return $this->event_type;
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
}