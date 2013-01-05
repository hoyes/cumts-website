<?php

namespace Cumts\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transactions")
 * @ORM\Entity(repositoryClass="Cumts\MainBundle\Entity\TransactionRepository")
 */
class Transaction
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Member")
     */
    private $member;

    /**
     * @var string
     *
     * @ORM\Column(name="member_name", type="string", length=255)
     */
    private $member_name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", precision=9, scale=2)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255)
     */
    private $product_name;

    /**
     * @var integer
     *
     * @ORM\Column(name="paypal_id", type="integer")
     */
    private $paypal_id;

    /**
     * @var string
     *
     * @ORM\Column(name="paypal_email", type="string", length=255)
     */
    private $paypal_email;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="transactions")
     */
    private $product;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;


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
     * Set member_name
     *
     * @param string $memberName
     * @return Transaction
     */
    public function setMemberName($memberName)
    {
        $this->member_name = $memberName;

        return $this;
    }

    /**
     * Get member_name
     *
     * @return string 
     */
    public function getMemberName()
    {
        return $this->member_name;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Transaction
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
     * Set product_name
     *
     * @param string $productName
     * @return Transaction
     */
    public function setProductName($productName)
    {
        $this->product_name = $productName;

        return $this;
    }

    /**
     * Get product_name
     *
     * @return string 
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Set paypal_id
     *
     * @param integer $paypalId
     * @return Transaction
     */
    public function setPaypalId($paypalId)
    {
        $this->paypal_id = $paypalId;

        return $this;
    }

    /**
     * Get paypal_id
     *
     * @return integer 
     */
    public function getPaypalId()
    {
        return $this->paypal_id;
    }

    /**
     * Set paypal_email
     *
     * @param string $paypalEmail
     * @return Transaction
     */
    public function setPaypalEmail($paypalEmail)
    {
        $this->paypal_email = $paypalEmail;

        return $this;
    }

    /**
     * Get paypal_email
     *
     * @return string 
     */
    public function getPaypalEmail()
    {
        return $this->paypal_email;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Transaction
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
     * Set member
     *
     * @param \Cumts\MainBundle\Entity\Member $member
     * @return Transaction
     */
    public function setMember(\Cumts\MainBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \Cumts\MainBundle\Entity\Member 
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set product
     *
     * @param \Cumts\MainBundle\Entity\Product $product
     * @return Transaction
     */
    public function setProduct(\Cumts\MainBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Cumts\MainBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Transaction
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
