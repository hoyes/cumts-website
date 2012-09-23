<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cumts\MainBundle\Entity\Member
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cumts\MainBundle\Entity\MemberRepository")
 */
class Member
{
    const TYPE_LIFE = 0;
    const TYPE_YEAR = 1;
    const TYPE_ASSOCIATE = 2;
    const TYPE_SPECIAL = 3;

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
    public function setMembershipType(\int8 $membershipType)
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
            case self::TYPE_LIFE: return "life";
            case self::TYPE_YEAR: return "one year";
            case self::TYPE_ASSOCIATE: return "associate";
            case self::TYPE_SPECIAL: return "special";
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
}
