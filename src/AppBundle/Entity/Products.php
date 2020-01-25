<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
* @ORM\Entity
* @ORM\Table(name="products")
* @UniqueEntity("code",message="El codigo ingresado ya se encuentra registrado.")
* @UniqueEntity("name",message="El nombre ingresado ya se encuentra registrado.")
*/
class Products {

    /**
     * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "El codigo tiene que ser minimo de {{ limit }} caracteres",
     *      maxMessage = "El codigo tiene que ser maximo de {{ limit }} caracteres"
     * )
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
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank
    */
    protected $mark;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message = "El precio debe ser un numero")
    */
    protected $price;


    /**
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;


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
     * @return Products
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
     * @return Products
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
     * @return Products
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
     * Set mark
     *
     * @param string $mark
     *
     * @return Products
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return string
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Products
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
     * Set category
     *
     * @param \AppBundle\Entity\Categories $category
     *
     * @return Products
     */
    public function setCategory(\AppBundle\Entity\Categories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Categories
     */
    public function getCategory()
    {
        return $this->category;
    }
    
}
