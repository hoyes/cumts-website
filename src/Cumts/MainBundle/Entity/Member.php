<?php

namespace Cumts\MainBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Cumts\MainBundle\Entity\Member
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cumts\MainBundle\Entity\MemberRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("auth_id")
 * @UniqueEntity("email")
 */
class Member implements UserInterface
{
    const TYPE_CURRENT = 0;
    const TYPE_YEAR = 1;
    const TYPE_ASSOCIATE = 2;
    const TYPE_SPECIAL = 3;
    const TYPE_COMMITTEE = 4;
    
    const UNPAID = -10;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $first_name
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $first_name;

    /**
     * @var string $last_name
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $last_name;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    
    /**
     * @var integer $membership_type
     *
     * @ORM\Column(name="membership_type", type="smallint")
     */
    private $membership_type;

    /**
     * @var string $auth_id
     *
     * @ORM\Column(name="auth_id", type="string", length=255)
     */
    private $auth_id;
    
    /**
     * @var string $college
     *
     * @ORM\Column(name="college", type="string", length=255)
     */
    private $college;
    
    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @var datetime $joined_at
     *
     * @ORM\Column(name="joined_at", type="datetime")
     */
    private $joined_at;
    
    /**
     * @var datetime $leaves_at
     *
     * @ORM\Column(name="leaves_at", type="datetime")
     */
    private $leaves_at;
    
    /**
     * @var boolean $paid
     *
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid;
    
    /**
     * @var integer $camdram_id
     *
     * @ORM\Column(name="camdram_id", type="integer", nullable=true)
     */
    private $camdram_id;

    public function __construct()
    {
        $this->joined_at = new \DateTime;
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
     * Set first_name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set joined_at
     *
     * @param datetime $joinedAt
     */
    public function setJoinedAt($joinedAt)
    {
        $this->joined_at = $joinedAt;
    }

    /**
     * Get joined_at
     *
     * @return datetime 
     */
    public function getJoinedAt()
    {
        return $this->joined_at;
    }

    /**
     * Set leaves_at
     *
     * @param datetime $leavesAt
     */
    public function setLeavesAt($leavesAt)
    {
        $this->leaves_at = $leavesAt;
    }

    /**
     * Get leaves_at
     *
     * @return datetime 
     */
    public function getLeavesAt()
    {
        return $this->leaves_at;
    }

    /**
     * Set membership_type
     *
     * @param int8 $membershipType
     */
    public function setMembershipType($membershipType)
    {
        $this->membership_type = $membershipType;
    }

    /**
     * Get membership_type
     *
     * @return int8 
     */
    public function getMembershipType()
    {
        return $this->membership_type;
    }
    
    public function getMembershipTypeString()
    {
        switch ($this->membership_type) {
            case self::TYPE_CURRENT: return "active";
            case self::TYPE_YEAR: return "one year";
            case self::TYPE_ASSOCIATE: return "associate";
            case self::TYPE_SPECIAL: return "special";
            case self::TYPE_COMMITTEE: return "committee";
        }
    }

    /**
     * Set auth_id
     *
     * @param string $authId
     */
    public function setAuthId($authId)
    {
        $this->auth_id = $authId;
    }

    /**
     * Get auth_id
     *
     * @return string 
     */
    public function getAuthId()
    {
        return $this->auth_id;
    }

    /**
     * Set college
     *
     * @param string $college
     */
    public function setCollege($college)
    {
        $this->college = $college;
    }

    /**
     * Get college
     *
     * @return string 
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * Get paid
     *
     * @return boolean 
     */
    public function getPaid()
    {
        return $this->paid;
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
    
    
    public function getUsername()
    {
        return $this->getAuthId();
    }
    
    public function getRoles()
    {
        switch($this->getMembershipType()) {
            case self::TYPE_CURRENT:
            case self::TYPE_YEAR:
            case self::TYPE_SPECIAL:
                return array('ROLE_CURRENT');
                break;
            case self::TYPE_COMMITTEE:
                return array('ROLE_COMMITTEE');
                break;
            default:
                return array('ROLE_MEMBER');
                break;
        }
    }
    
    public function getPassword()
    {
        return null;
    }
    public function getSalt()
    {
        return null;
    }
    
    public function equals(UserInterface $user)
    {
        return $user->getUsername() == $this->getAuthId();
    }
    public function eraseCredentials()
    {
    }
    
    public function getFullName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    /**
     * Set camdram_id
     *
     * @param integer $camdramId
     * @return Member
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
