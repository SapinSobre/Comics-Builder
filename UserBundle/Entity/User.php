<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Validator\Antiflood;
use GameBundle\Entity\Partie;



/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="username", message="Un autre utilisateur utilise déjà ce login.")
 * @UniqueEntity(fields="mail", message="Cet email est déjà utilisé sur Story Builder.")   
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="friends", cascade={"persist"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=2, minMessage="Votre prénom doit au moins contenir {{ limit }} caractères.", max=25, maxMessage="Votre prénom doit contenir moins de {{ limit }} caractères.")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=2, minMessage="Votre nom doit au moins contenir {{ limit }} caractères.", max=25, maxMessage="Votre nom doit contenir moins de {{ limit }} caractères.")
     * @Antiflood()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=2, minMessage="Votre login doit au moins contenir {{ limit }} caractères.", max=8, maxMessage="Votre login doit contenir moins de {{ limit }} caractères.")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Type("string")
     * @Assert\Length(min=7, minMessage="Votre mot de passe doit au moins contenir {{ limit }} caractères.", max=20, maxMessage="Votre mot de passe doit contenir moins de {{ limit }} caractères.")
     * @Assert\NotBlank()
     *
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $mail;


    /**
     *
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min=2, minMessage="Le nom de votre ville doit au moins contenir {{ limit }} caractères.", max=25, maxMessage="Le nom de votre ville ne peut pas contenir plus de {{ limit }} caractères.")
     */
    private $city;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotBlank()
     */
    private $birth;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\ImageUser", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private $imageUser;


    /**
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotBlank()
     */
    private $createdAt;


    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = true;


    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Picture", mappedBy="user", cascade={"persist", "remove", "merge"})
     *
     */
    private $pictures;

    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Concours", mappedBy="user", cascade={"persist", "remove", "merge"})
     *
     */
    private $concourss;

    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Advert", mappedBy="user", cascade={"persist", "remove", "merge"})
     *
     */
    private $adverts;


    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\CommentAdvertText", mappedBy="user", cascade={"persist", "remove", "merge"})
     *
     */
    private $commentAdvertTexts;

    /**
     * @ORM\ManyToMany(targetEntity="GameBundle\Entity\Partie", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="partie_user")
     */
    private $parties = array();

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", cascade={"persist"})
     *
     */
    private $friends = array();

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

    public function __construct(array $data=null)
    {
        if($data != null)
        {
            $user = $data["user"];
            $this->setUser($user);
        }

        $this->roles = array();
        $this->roles[] = 'ROLE_USER';
        $this->salt = "";
        $this->createdAt = new \DateTime();
        $this->pictures = array();
        $this->concourss = array();
        $this->adverts = array();
        $this->commentAdvertTexts = array();
        $this->parties = new ArrayCollection();
        $this->friends = new ArrayCollection();
    }

    /**
     * @Assert\Callback
     */
    public function isPasswdValid(ExecutionContextInterface $context)
    {
        $username = $this->getUsername();
        $pass = $this->getPassword();
        if ($username == $pass) {
            $context
                ->buildViolation('Votre mot de passe ne peut pas contenir votre login.')
                ->atPath('password')
                ->addViolation();

        }
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set mail
     *
     * @param string $mail
     *
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set birth
     *
     * @param \DateTime $birth
     *
     * @return User
     */
    public function setBirth($birth)
    {
        $this->birth = $birth;

        return $this;
    }

    /**
     * Get birth
     *
     * @return \DateTime
     */
    public function getBirth()
    {
        return $this->birth;
    }


    /**
     * Set imageUser
     *
     * @param \UserBundle\Entity\ImageUser $imageUser
     *
     * @return User
     */
    public function setImageUser(ImageUser $imageUser)
    {
        $this->imageUser = $imageUser;

        return $this;
    }

    /**
     * Get imageUser
     *
     * @return \UserBundle\Entity\ImageUser
     */
    public function getImageUser()
    {
        return $this->imageUser;
    }


    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
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
     * Add picture
     *
     * @param \UserBundle\Entity\Picture $picture
     * @return User
     */
    public function addPicture(Picture $picture)
    {
        $this->pictures[] = $picture;

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \UserBundle\Entity\Picture $picture
     */
    public function removePicture(Picture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Add advert
     *
     * @param \ForumBundle\Entity\Advert $advert
     *
     * @return User
     */
    public function addAdvert(\ForumBundle\Entity\Advert $advert)
    {
        $this->adverts[] = $advert;

        return $this;
    }

    /**
     * Remove advert
     *
     * @param \ForumBundle\Entity\Advert $advert
     */
    public function removeAdvert(\ForumBundle\Entity\Advert $advert)
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

    /**
     * Add commentAdvertText
     *
     * @param \ForumBundle\Entity\CommentAdvertText $commentAdvertText
     *
     * @return User
     */
    public function addCommentAdvertText(\ForumBundle\Entity\CommentAdvertText $commentAdvertText)
    {
        $this->commentAdvertTexts[] = $commentAdvertText;

        return $this;
    }

    /**
     * Remove commentAdvertText
     *
     * @param \ForumBundle\Entity\CommentAdvertText $commentAdvertText
     */
    public function removeCommentAdvertText(\ForumBundle\Entity\CommentAdvertText $commentAdvertText)
    {
        $this->commentAdvertTexts->removeElement($commentAdvertText);
    }

    /**
     * Get commentAdvertTexts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentAdvertTexts()
    {
        return $this->commentAdvertTexts;
    }

    /**
     * Add concours
     *
     * @param \ForumBundle\Entity\Concours $concours
     *
     * @return User
     */
    public function addConcours(\ForumBundle\Entity\Concours $concours)
    {
        $this->concourss[] = $concours;

        return $this;
    }

    /**
     * Remove concours
     *
     * @param \ForumBundle\Entity\Concours $concours
     */
    public function removeConcours(\ForumBundle\Entity\Concours $concours)
    {
        $this->concourss->removeElement($concours);
    }

    /**
     * Get concourss
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConcourss()
    {
        return $this->concourss;
    }

    /**
     * Remove concourss
     *
     * @param \ForumBundle\Entity\Concours $concourss
     */
    public function removeConcourss(\ForumBundle\Entity\Concours $concourss)
    {
        $this->concourss->removeElement($concourss);
    }

    /**
     * Add partie
     *
     * @param \GameBundle\Entity\Partie $partie
     * @return User
     */
    public function addPartie(Partie $partie)
    {
        if(!in_array($partie, $this->parties->toArray())){
            $this->parties[] = $partie;
        }


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

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
             $this->salt
            ) = unserialize($serialized);
    }

    /**
     * Add concourss
     *
     * @param \ForumBundle\Entity\Concours $concourss
     *
     * @return User
     */
    public function addConcourss(\ForumBundle\Entity\Concours $concourss)
    {
        $this->concourss[] = $concourss;

        return $this;
    }

    /**
     * Add party
     *
     * @param \GameBundle\Entity\Partie $party
     *
     * @return User
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

    /**
     * Add friend
     *
     * @param \UserBundle\Entity\User $friend
     *
     * @return User
     */
    public function addFriend(\UserBundle\Entity\User $friend)
    {
        $this->friends[] = $friend;

        return $this;
    }

    /**
     * Remove friend
     *
     * @param \UserBundle\Entity\User $friend
     */
    public function removeFriend(\UserBundle\Entity\User $friend)
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends()
    {
        return $this->friends;
    }
}
