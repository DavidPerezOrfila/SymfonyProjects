<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints As Assert;

/**
 * tapas
 *
 * @ORM\Table(name="tapas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\tapasRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class tapas
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")     *
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(
     *     min="4",
     *     max="20",
     *     minMessage="nazwa too short",
     *     maxMessage="nazwa too long"
     * )
     * @Assert\NotBlank(message="nazwa cannot be empty")
     * @ORM\Column(name="nazwa", type="string", length=255, unique=false)
     */
    private $nazwa;

    /**
     * @var string
     * @ORM\Column(name="opis", type="string", length=255)
     */
    private $opis;

    /**
     * @var double
     * @Assert\NotBlank(message="cena cannot be empty")
     * @ORM\Column(name="cena", type="decimal", precision=6, scale=2)
     */
    private $cena;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return tapas
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set opis
     *
     * @param string $opis
     *
     * @return tapas
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;

        return $this;
    }

    /**
     * Get opis
     *
     * @return string
     */
    public function getOpis()
    {
        return $this->opis;
    }

    /**
     * Set cena
     *
     * @param string $cena
     *
     * @return tapas
     */
    public function setCena($cena)
    {
        $this->cena = $cena;

        return $this;
    }

    /**
     * Get cena
     *
     * @return string
     */
    public function getCena()
    {
        return $this->cena;
    }



    /**
     * tapas constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
    }
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return tapas
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     * @ORM\PreUpdate()
     * @return tapas
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
