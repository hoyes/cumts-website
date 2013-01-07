<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cumts\MainBundle\Entity\Photo
 *
 * @ORM\Table(name="photos")
 * @ORM\Entity(repositoryClass="PhotoRepository")
 */
class Photo
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
     * @var Show $show
     *
     * @ORM\ManyToOne(targetEntity="Show", inversedBy="performances")
     * @ORM\JoinColumn(name="show_id", referencedColumnName="id")
     */
    private $show;
    
    /**
     * @ORM\OneToOne(targetEntity="Hoyes\ImageManagerBundle\Entity\Image", fetch="EAGER")
     */
    private $image;
    
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;


    public function __construct()
    {
        $this->created_at = new \DateTime;
    }

    /**
     * Set show
     *
     * @param Cumts\MainBundle\Entity\Show $show
     * @return Performance
     */
    public function setShow(\Cumts\MainBundle\Entity\Show $show = null)
    {
        $this->show = $show;
    
        return $this;
    }

    /**
     * Get show
     *
     * @return Cumts\MainBundle\Entity\Show 
     */
    public function getShow()
    {
        return $this->show;
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
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Photo
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
     * Set image
     *
     * @param \Hoyes\ImageManagerBundle\Entity\Image $image
     * @return Photo
     */
    public function setImage(\Hoyes\ImageManagerBundle\Entity\Image $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return \Hoyes\ImageManagerBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}
