<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @ORM\Column(name="GameId", type="string", length=255)
     */
    private $gameId;

    /**
     * @var string
     *
     * @ORM\Column(name="UserId", type="string", length=255)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="EspaceMembreBundle\Entity\ImageAll", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $imageAll;

    /**
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Partie", inversedBy="answers", cascade={"all"})
     * @ORM\JoinColumn(fieldName="partie_id", referencedColumnName="id")
     */
    private $partie;

    /**
     * @return mixed
     */
    public function getPartie()
    {
        return $this->partie;
    }

    /**
     * @param mixed $partie
     */
    public function setPartie($partie = null)
    {
        $this->partie = $partie;
    }

    public function eraseCredentials()
    {

    }

    private $file;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * Set gameId
     *
     * @param string $gameId
     *
     * @return Answer
     */
    public function setGameId($gameId)
    {
        $this->gameId = $gameId;

        return $this;
    }

    /**
     * Get gameId
     *
     * @return string
     */
    public function getGameId()
    {
        return $this->gameId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     *
     * @return Answer
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Answer
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Answer
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Answer
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
     * Set imageAll
     *
     * @param \EspaceMembreBundle\Entity\ImageAll $imageAll
     *
     * @return Answer
     */
    public function setImageAll(\EspaceMembreBundle\Entity\ImageAll $imageAll = null)
    {
        $this->imageAll = $imageAll;

        return $this;
    }

    /**
     * Get imageAll
     *
     * @return \EspaceMembreBundle\Entity\ImageAll
     */
    public function getImageAll()
    {
        return $this->imageAll;
    }

}
