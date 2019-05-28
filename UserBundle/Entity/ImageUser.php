<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageUser
 *
 * @ORM\Table(name="image_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\ImageUserRepository")
 */
class ImageUser
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return ImageUser
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
     * @return ImageUser
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
        return '../../../../web/uploads/user/images/';
    }
        
    public function getUploadRootDir(){
       return __DIR__.$this->getUploadDir();     
    }
        
}

