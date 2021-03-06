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
class Show extends Event
{

    protected $event_type = 'show';
    protected $event_string = 'Show';

    /**
     * @var string $author
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;

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
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="show")
     */    
    private $photos;


    public function __construct()
    {
        $this->performances = new ArrayCollection();
        $this->roles = new ArrayCollection();
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
     * Add performances
     *
     * @param \Cumts\MainBundle\Entity\Performance $performances
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
     * @param \Cumts\MainBundle\Entity\Performance $performances
     */
    public function removePerformance(\Cumts\MainBundle\Entity\Performance $performances)
    {
        $this->performances->removeElement($performances);
    }

    /**
     * Get performances
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPerformances()
    {
        return $this->performances;
    }

    /**
     * Add roles
     *
     * @param \Cumts\MainBundle\Entity\ShowRole $roles
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
     * @param \Cumts\MainBundle\Entity\ShowRole $roles
     */
    public function removeRole(\Cumts\MainBundle\Entity\ShowRole $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add photos
     *
     * @param \Cumts\MainBundle\Entity\Photo $photos
     * @return Show
     */
    public function addPhoto(\Cumts\MainBundle\Entity\Photo $photos)
    {
        $this->photos[] = $photos;
    
        return $this;
    }

    /**
     * Remove photos
     *
     * @param \Cumts\MainBundle\Entity\Photo $photos
     */
    public function removePhoto(\Cumts\MainBundle\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }

}
