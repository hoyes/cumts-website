<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Cumts\MainBundle\Entity\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", precision=9, scale=2)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="members_price", type="decimal", precision=9, scale=2, nullable=true)
     */
    private $members_price;

    /**
     * @var float
     *
     * @ORM\Column(name="max_quantity", type="integer", nullable=true)
     */
    private $max_quantity = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=255)
     */
    private $contact_email;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_available", type="integer", nullable=true)
     */
    private $number_available;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_sold", type="integer", nullable=false)
     */
    private $number_sold = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="requires_membership", type="boolean")
     */
    private $requires_membership;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="product")
     */
    private $transactions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created_at = new \DateTime;
        $this->updated_at = new \DateTime;
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
     * @return Product
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
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set contact_email
     *
     * @param string $contactEmail
     * @return Product
     */
    public function setContactEmail($contactEmail)
    {
        $this->contact_email = $contactEmail;

        return $this;
    }

    /**
     * Get contact_email
     *
     * @return string 
     */
    public function getContactEmail()
    {
        return $this->contact_email;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Product
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
     * @return Product
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
     * Add transactions
     *
     * @param \Cumts\MainBundle\Entity\Transaction $transactions
     * @return Product
     */
    public function addTransaction(\Cumts\MainBundle\Entity\Transaction $transactions)
    {
        $this->transactions[] = $transactions;

        return $this;
    }

    /**
     * Remove transactions
     *
     * @param \Cumts\MainBundle\Entity\Transaction $transactions
     */
    public function removeTransaction(\Cumts\MainBundle\Entity\Transaction $transactions)
    {
        $this->transactions->removeElement($transactions);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Set number_available
     *
     * @param integer $numberAvailable
     * @return Product
     */
    public function setNumberAvailable($numberAvailable)
    {
        $this->number_available = $numberAvailable;

        return $this;
    }

    /**
     * Get number_available
     *
     * @return integer 
     */
    public function getNumberAvailable()
    {
        return $this->number_available;
    }

    /**
     * Set requires_membership
     *
     * @param boolean $requiresMembership
     * @return Product
     */
    public function setRequiresMembership($requiresMembership)
    {
        $this->requires_membership = $requiresMembership;

        return $this;
    }

    /**
     * Get requires_membership
     *
     * @return boolean 
     */
    public function getRequiresMembership()
    {
        return $this->requires_membership;
    }

    /**
     * Set members_price
     *
     * @param float $membersPrice
     * @return Product
     */
    public function setMembersPrice($membersPrice)
    {
        $this->members_price = $membersPrice;

        return $this;
    }

    /**
     * Get members_price
     *
     * @return float 
     */
    public function getMembersPrice()
    {
        return $this->members_price;
    }

    /**
     * Set max_quantity
     *
     * @param integer $maxQuantity
     * @return Product
     */
    public function setMaxQuantity($maxQuantity)
    {
        $this->max_quantity = $maxQuantity;

        return $this;
    }

    /**
     * Get max_quantity
     *
     * @return integer 
     */
    public function getMaxQuantity()
    {
        return $this->max_quantity;
    }

    /**
     * Set number_sold
     *
     * @param integer $numberSold
     * @return Product
     */
    public function setNumberSold($numberSold)
    {
        $this->number_sold = $numberSold;

        return $this;
    }

    /**
     * Get number_sold
     *
     * @return integer 
     */
    public function getNumberSold()
    {
        return $this->number_sold;
    }
}