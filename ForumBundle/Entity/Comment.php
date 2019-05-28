<?php
namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;

/**
 * @ORM\MappedSuperclass
 *
 */
abstract class Comment
{
    /**
     * @var string $title
     * @Assert\Length(min=2, minMessage="Votre commentaire doit au moins contenir deux caractères.")
     * @ORM\Column(name="title", type="string", length=255)
     *
     */
    protected $title;

    /**
     * @ORM\Column(name="extrait", type="text")
     */
    protected $extrait;

    /**
     * @ORM\Column(name="createdAt", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="commentAdvertTexts", cascade={"persist"})
     */
    protected $user;

    public function __construct(array $data=null){
        if ($data != null) {
            $user = $data["user"];
            $this->user = $user;
        }
        $this->createdAt = new \DateTime();
    }

    function getTitle(){
        return $this->title;
    }
    function setTitle($title){
        $this->title = $title;
        return $this;
    }
    function getCreatedAt(){
        return $this->createdAt;
    }
    function setCreatedAt($date){
        $this->createdAt = $date;
        return $this;
    }
    function getExtrait(){
        return $this->extrait;
    }
    function setExtrait($extrait){
        $this->extrait = $extrait;
        return $this;
    }
    function getUser(){
        return $this->user;
    }
    function setUser($user){
        $this->user = $user;
    }

}
