<?php

namespace GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use UserBundle\Entity\User;

/**
 * Partie
 *
 * @ORM\Table(name="partie")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\PartieRepository")
 * 
 */
class Partie
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
     * @ORM\Column(name="titre", type="string", length=255, unique=true)
     */
    private $titre;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
    * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Game", inversedBy="parties")
    * @ORM\JoinColumn(nullable=false)
    */
    private $game;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="parties", cascade={"all"})
     */
    private $users = array();

    /**
     * @ORM\OneToMany(targetEntity="GameBundle\Entity\Answer", mappedBy="partie", cascade={"all"})
     */
    private $answers = array();
    
    public function __construct()
    {
        $this->createdAt = new \Datetime();
        $this->answers = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Partie
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Partie
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
     * Set game
     *
     * @param \GameBundle\Entity\Game $game
     *
     * @return Partie
     */
    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \GameBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }


    /**
     * Add answer
     *
     * @param \GameBundle\Entity\Answer $answer
     *
     * @return Partie
     */
    public function addAnswer(\GameBundle\Entity\Answer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \GameBundle\Entity\Answer $answer
     */
    public function removeAnswer(\GameBundle\Entity\Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Add user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Partie
     */
    public function addUser(\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \UserBundle\Entity\User $user
     */
    public function removeUser(\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
