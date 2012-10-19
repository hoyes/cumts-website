<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cumts\MainBundle\Entity\ShowRole
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cumts\MainBundle\Entity\ShowRoleRepository")
 */
class ShowRole
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $role
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @var Member $member
     *
     * @ORM\ManyToOne(targetEntity="Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     */
    private $member;

    /**
     * @var string $role_type
     *
     * @ORM\Column(name="role_type", type="string", length=10)
     */
    private $role_type;

    /**
     * @var integer $sort
     *
     * @ORM\Column(name="sort", type="integer")
     */
    private $sort;
    
     /**
     * @var integer $camdram_id
     *
     * @ORM\Column(name="camdram_id", type="integer")
     */
    private $camdram_id;

    /**
     * @var Show $show
     *
     * @ORM\ManyToOne(targetEntity="Show")
     * @ORM\JoinColumn(name="show_id", referencedColumnName="id")
     */
    private $show;


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
     * @return ShowRole
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
     * Set role
     *
     * @param string $role
     * @return ShowRole
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set member_id
     *
     * @param integer $memberId
     * @return ShowRole
     */
    public function setMemberId($memberId)
    {
        $this->member_id = $memberId;
    
        return $this;
    }

    /**
     * Get member_id
     *
     * @return integer 
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     * Set role_type
     *
     * @param string $roleType
     * @return ShowRole
     */
    public function setRoleType($roleType)
    {
        $this->role_type = $roleType;
    
        return $this;
    }

    /**
     * Get role_type
     *
     * @return string 
     */
    public function getRoleType()
    {
        return $this->role_type;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return ShowRole
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set show_id
     *
     * @param integer $showId
     * @return ShowRole
     */
    public function setShowId($showId)
    {
        $this->show_id = $showId;
    
        return $this;
    }

    /**
     * Get show_id
     *
     * @return integer 
     */
    public function getShowId()
    {
        return $this->show_id;
    }

    /**
     * Set member
     *
     * @param Cumts\MainBundle\Entity\Member $member
     * @return ShowRole
     */
    public function setMember(\Cumts\MainBundle\Entity\Member $member = null)
    {
        $this->member = $member;
    
        return $this;
    }

    /**
     * Get member
     *
     * @return Cumts\MainBundle\Entity\Member 
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set show
     *
     * @param Cumts\MainBundle\Entity\Show $show
     * @return ShowRole
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
     * Set camdram_id
     *
     * @param integer $camdramId
     * @return ShowRole
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
}