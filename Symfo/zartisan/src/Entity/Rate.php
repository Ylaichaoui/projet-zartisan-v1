<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RateRepository")
 */
class Rate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")

     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user_artisan_single","rate_value"})
     */
    private $value;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user_artisan_single"})
     */
    public $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_artisan_single"})
     */
    public $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userAuthor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rate")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userPro;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCreatedAt()
    {
        if($this->createdAt != NULL){
            return $this->createdAt->format('d/m/Y H:i:s');
        }
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        if($this->updatedAt != NULL){
            return $this->updatedAt->format('d/m/Y H:i:s');
        }
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUserAuthor(): ?User
    {
        return $this->userAuthor;
    }

    public function setUserAuthor(?User $userAuthor): self
    {
        $this->userAuthor = $userAuthor;

        return $this;
    }

    public function getUserPro(): ?User
    {
        return $this->userPro;
    }

    public function setUserPro(?User $userPro): self
    {
        $this->userPro = $userPro;

        return $this;
    }
}
