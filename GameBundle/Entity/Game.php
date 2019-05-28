<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GameBundle\Entity\Partie;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\GameRepository")
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="rule", type="text")
     */
    private $rule;

    /**
     * @var string
     *
     * @ORM\Column(name="nbPart", type="string", length=255)
     */
    private $nbPart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CreatedAt", type="string", length=255)
     */
    private $createdAt;

    /**
    * @ORM\OneToOne(targetEntity="GameBundle\Entity\Image", cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $image;

    /**
    * @ORM\OneToMany(targetEntity="GameBundle\Entity\Partie", mappedBy="game")
    */
    private $parties; 
    
    public function __construct()
    {
      $this->createdAt = new DateTime();
      $this->parties= new ArrayCollection();
    }
    
    
    
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
     * Set name
     *
     * @param string $name
     *
     * @return Game
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
     * Set rule
     *
     * @param string $rule
     *
     * @return Game
     */
    public function setRule($rule)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Set nbPart
     *
     * @param string $nbPart
     *
     * @return Game
     */
    public function setNbPart($nbPart)
    {
        $this->nbPart = $nbPart;

        return $this;
    }

    /**
     * Get nbPart
     *
     * @return string
     */
    public function getNbPart()
    {
        return $this->nbPart;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return Game
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set image
     *
     * @param \GameBundle\Entity\Image $image
     *
     * @return Game
     */
    public function setImage(Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \GameBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add partie
     *
     * @param \GameBundle\Entity\Partie $partie
     *
     * @return Game
     */
    public function addPartie(Partie $partie)
    {
        $this->parties[] = $partie;
        $partie->setGame($this);

        return $this;
    }

    /**
     * Remove partie
     *
     * @param \GameBundle\Entity\Partie $partie
     */
    public function removePartie(Partie $partie)
    {
        $this->parties->removeElement($partie);
    }

    /**
     * Get parties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParties()
    {
        return $this->parties;
    }

    /**
     * Add party
     *
     * @param \GameBundle\Entity\Partie $party
     *
     * @return Game
     */
    public function addParty(\GameBundle\Entity\Partie $party)
    {
        $this->parties[] = $party;

        return $this;
    }

    /**
     * Remove party
     *
     * @param \GameBundle\Entity\Partie $party
     */
    public function removeParty(\GameBundle\Entity\Partie $party)
    {
        $this->parties->removeElement($party);
    }
}
