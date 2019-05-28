<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use ForumBundle\Entity\Advert;
use EspaceMembreBundle\Entity\ImageAll;


/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\PictureRepository")
 */
class Picture
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
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\Url()
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    
    
    /**
     * @var bool
     *
     * @ORM\Column(name="isAdvert", type="boolean")
     */
    private $isAdvert;

    /**
     * @var bool
     *
     * @ORM\Column(name="isComment", type="boolean")
     */
    private $isComment;

    /**
     * @var bool
     *
     * @ORM\Column(name="isRound", type="boolean")
     */
    private $isRound;

    /**
     * @var bool
     *
     * @ORM\Column(name="isUser", type="boolean")
     */
    private $isUser;

    /**
     * @var bool
     *
     * @ORM\Column(name="isRoundUser", type="boolean")
     */
    private $isRoundUser;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255, nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255, nullable=true)
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;
    
    /**
    * @ORM\OneToOne(targetEntity="EspaceMembreBundle\Entity\ImageAll", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $imageAll;
    
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    
    
    /**
     * Set url
     *
     * @param string $url
     *
     * @return ImageAll
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
     * @return ImageAll
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
       
    public function __construct(array $data=null){
        if($data != null)
        {
            $user = $data["user"];
            $this->setUser($user);
        }
            
        //$session = $request->getSession();
        //$username = $session->get('username');
        $this->isAdvert = true;
        $this->isComment = true;
        $this->isRound = true;
        $this->isUser = true;
        $this->isRoundUser = true;
        $this->createdAt = new \DateTime();
        //$this->user = $this->choiceUser($username);
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
     * Set id
     *
     * @return int
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Set isAdvert
     *
     * @param boolean $isAdvert
     *
     * @return Picture
     */
    public function setIsAdvert($isAdvert)
    {
        $this->isAdvert = $isAdvert;

        return $this;
    }

    /**
     * Get isAdvert
     *
     * @return bool
     */
    public function getIsAdvert()
    {
        return $this->isAdvert;
    }

    /**
     * Set isComment
     *
     * @param boolean $isComment
     *
     * @return Picture
     */
    public function setIsComment($isComment)
    {
        $this->isComment = $isComment;

        return $this;
    }

    /**
     * Get isComment
     *
     * @return bool
     */
    public function getIsComment()
    {
        return $this->isComment;
    }

    /**
     * Set isRound
     *
     * @param boolean $isRound
     *
     * @return Picture
     */
    public function setIsRound($isRound)
    {
        $this->isRound = $isRound;

        return $this;
    }

    /**
     * Get isRound
     *
     * @return bool
     */
    public function getIsRound()
    {
        return $this->isRound;
    }

    /**
     * Set isUser
     *
     * @param boolean $isUser
     *
     * @return Picture
     */
    public function setIsUser($isUser)
    {
        $this->isUser = $isUser;

        return $this;
    }

    /**
     * Get isUser
     *
     * @return bool
     */
    public function getIsUser()
    {
        return $this->isUser;
    }

    /**
     * Set isRoundUser
     *
     * @param boolean $isRoundUser
     *
     * @return Picture
     */
    public function setIsRoundUser($isRoundUser)
    {
        $this->isRoundUser = $isRoundUser;

        return $this;
    }

    /**
     * Get isRoundUser
     *
     * @return bool
     */
    public function getIsRoundUser()
    {
        return $this->isRoundUser;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Picture
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
     * @return Picture
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
     * Set date
     *
     * @param string $date
     *
     * @return Picture
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Picture
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Picture
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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Picture
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
     * Set imageAll
     *
     * @param \EspaceMembreBundle\Entity\ImageAll $imageAll
     *
     * @return Picture
     */
    public function setImageAll(ImageAll $imageAll)
    {
        $this->imageAll = $imageAll;

        return $this;
    }

    /**
     * Get imageAll
     *
     * @return \EspaceMembreBundle\Entity\ImageAll
     * 
     */
    public function getImageAll()
    {
        return $this->imageAll;
    }
    
    public function addImage($image)
    {
        $this->imageAll[] = $image;
    }

    /**
     * Add advert
     *
     * @param \ForumBundle\Entity\Advert $advert
     *
     * @return Picture
     */
    public function addAdvert(Advert $advert)
    {
        $this->adverts[] = $advert;

        return $this;
    }

    /**
     * Remove advert
     *
     * @param \ForumBundle\Entity\Advert $advert
     */
    public function removeAdvert(Advert $advert)
    {
        $this->adverts->removeElement($advert);
    }

    /**
     * Get adverts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdverts()
    {
        return $this->adverts;
    }
}
