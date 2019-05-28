<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\AdvertRepository")
 */
class Advert
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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="cateAdvert", type="string", length=255)
     */
    private $cateAdvert;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="adverts")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="EspaceMembreBundle\Entity\ImageAll", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $imageAll;

    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\CommentAdvertText", mappedBy="advert", cascade={"persist", "remove", "merge"})
     *
     */
    private $CommentAdvertTexts;
    


    public function __construct(array $data=null)
    {
        if ($data != null) {
            $user = $data["user"];
            $this->user = $user;
        }
        $this->createdAt = new \DateTime();

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



    public function upload(){

        //SI CHAMP FACULTATIF
        if(null === $this->file){
            return;
        }

        $name = $this->file->getClientOriginalName();
        $this->file->move($this->getUploadRootDir(),$name);
        $this->url=$name;
        $this->alt=$name;
    }

    public function getUploadDir(){
        return '../../../../web/uploads/espacemembre/images/';
    }

    public function getUploadRootDir(){
        return __DIR__.$this->getUploadDir();
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
     * Set title
     *
     * @param string $title
     *
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Advert
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
     * Set cateAdvert
     *
     * @param string $cateAdvert
     *
     * @return Advert
     */
    public function setCateAdvert($cateAdvert)
    {
        $this->cateAdvert = $cateAdvert;

        return $this;
    }

    /**
     * Get cateAdvert
     *
     * @return string
     */
    public function getCateAdvert()
    {
        return $this->cateAdvert;
    }

    /**
     * Set imageAll
     *
     * @param \EspaceMembreBundle\Entity\ImageAll $imageAll
     *
     * @return Advert
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

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Advert
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
     * @return Advert
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Advert
     */
    public function setUser(\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add commentAdvertText
     *
     * @param \ForumBundle\Entity\CommentAdvertText $commentAdvertText
     *
     * @return Advert
     */
    public function addCommentAdvertText(\ForumBundle\Entity\CommentAdvertText $commentAdvertText)
    {
        $this->CommentAdvertTexts[] = $commentAdvertText;

        return $this;
    }

    /**
     * Remove commentAdvertText
     *
     * @param \ForumBundle\Entity\CommentAdvertText $commentAdvertText
     */
    public function removeCommentAdvertText(\ForumBundle\Entity\CommentAdvertText $commentAdvertText)
    {
        $this->CommentAdvertTexts->removeElement($commentAdvertText);
    }

    /**
     * Get commentAdvertTexts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentAdvertTexts()
    {
        return $this->CommentAdvertTexts;
    }
}
