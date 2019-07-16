<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * One user have many Posts
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * Many likes can be affected to one Post
     * @ORM\OneToMany(targetEntity="App\Entity\Like", mappedBy="post" )
     */
    private $likes;

    /**
     * Many Comments can be affected to one Post
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post")
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\Expose
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\Expose
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): Post
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): Post
    {
        $this->image = $image;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user): Post
    {
        $this->user = $user;

        return $this;
    }



    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): Post
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): Post
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function addComment(Comment $comment): Post
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
        }
        return $this;
    }
    public function removeComment(Comment $comment): Post
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
        }
    }

    public function addLike(Like $like): Post
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }
        return $this;
    }
    public function removeLike(Like $like): Post
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
        }
    }

    }
