<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentAdvertText
 *
 * @ORM\Table(name="comment_advert_text")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CommentAdvertTextRepository")
 */
class CommentAdvertText extends Comment
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
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Advert", inversedBy="CommentAdvertTexts")
     */
    private $advert;

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
     * Set advert
     *
     * @param \ForumBundle\Entity\Advert $advert
     *
     * @return CommentAdvertText
     */
    public function setAdvert(\ForumBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \ForumBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }
}
