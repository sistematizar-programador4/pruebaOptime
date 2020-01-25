<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="categories")
* @UniqueEntity("code",message="El codigo ingresado ya se encuentra registrado.")
* @UniqueEntity("name",message="El nombre ingresado ya se encuentra registrado.")
*/
class Categories {

    /**
     * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern="/^\S+\w{8,32}\S{1,}/",
     *     match=false,
     *     message="El codigo no puede contener caracteres espaciales o espacios"
     * )
    */
    protected $code;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "El nombre tiene que ser minimo de {{ limit }} caracteres",
     *      maxMessage = "El nombre tiene que ser maximo de {{ limit }} caracteres"
     * )
    */
    protected $name;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank
    */
    protected $description;

    /**
     * @ORM\Column(type="boolean")
    */
    protected $active;

    /**
     * @ORM\OneToMany(targetEntity="Products", mappedBy="category")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * Transform to string
     * 
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
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
     * Set code
     *
     * @param string $code
     *
     * @return Categories
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Categories
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
     * Set description
     *
     * @param string $description
     *
     * @return Categories
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Categories
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Products $product
     *
     * @return Categories
     */
    public function addProduct(\AppBundle\Entity\Products $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Products $product
     */
    public function removeProduct(\AppBundle\Entity\Products $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
