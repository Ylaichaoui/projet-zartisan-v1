<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user_artisan_single", "user_user_single", "user_advice","user_artisan_search","user_artisan_advice"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user_artisan_single", "user_user_single", "user_artisan_search","user_artisan_advice"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $mailToken;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $isConfirmMail;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $isStatus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"user_user_single","user_artisan_single","user_artisan_advice"})
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_artisan_single","user_artisan_search","user_artisan_advice"})
     */
    private $company;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user_artisan_single","user_artisan_search","user_artisan_advice"})
     */
    private $companyDescription;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user_artisan_single","user_artisan_advice"})
     */
    private $naf;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $adressSupp;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single"})
     */
    private $specialDistribution;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $extNumberWay;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $numberWay;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $typeWay;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $way;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user_artisan_single","user_artisan_search","user_artisan_advice"})
     */
    private $isVerified;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_search","user_artisan_advice"})
     */
    private $picture;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user_artisan_single","user_artisan_advice"})
     */
    private $pictureFolder = [];

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"user_artisan_single","user_artisan_search","user_artisan_advice"})
     */
    private $region;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"user_artisan_single","user_artisan_search","user_artisan_advice"})
     */
    private $averageRate;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("user_artisan_single")
     */
    private $isReported;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_artisan_single", "user_user_single","user_artisan_advice"})
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advice", mappedBy="userAuthor")
     */
    private $advices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advice", mappedBy="userPro", fetch="EAGER")
     * @Groups("user_artisan_single")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $advice;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rate", mappedBy="userAuthor")
     */
    private $rates;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rate", mappedBy="userPro", fetch="EAGER")
     * @Groups("user_artisan_single")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $rate;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     * @Groups({"user_artisan_single","user_artisan_advice"})
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups("user_user_single")
     */
    private $nickname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", inversedBy="users")
     */
    private $job;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $emailCreatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $passCreatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $passToken;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->advices = new ArrayCollection();
        $this->advice = new ArrayCollection();
        $this->rates = new ArrayCollection();
        $this->rate = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_UNDEFINED
        $roles[] = 'ROLE_UNDEFINED';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getMailToken(): ?string
    {
        return $this->mailToken;
    }

    public function setMailToken(?string $mailToken): self
    {
        $this->mailToken = $mailToken;

        return $this;
    }

    public function getIsConfirmMail(): ?bool
    {
        return $this->isConfirmMail;
    }

    public function setIsConfirmMail(bool $isConfirmMail): self
    {
        $this->isConfirmMail = $isConfirmMail;

        return $this;
    }

    public function getIsStatus(): ?bool
    {
        return $this->isStatus;
    }

    public function setIsStatus(bool $isStatus): self
    {
        $this->isStatus = $isStatus;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCompanyDescription(): ?string
    {
        return $this->companyDescription;
    }

    public function setCompanyDescription(?string $companyDescription): self
    {
        $this->companyDescription = $companyDescription;

        return $this;
    }

    public function getNaf(): ?string
    {
        return $this->naf;
    }

    public function setNaf(?string $naf): self
    {
        $this->naf = $naf;

        return $this;
    }

    public function getAdressSupp(): ?string
    {
        return $this->adressSupp;
    }

    public function setAdressSupp(?string $adressSupp): self
    {
        $this->adressSupp = $adressSupp;

        return $this;
    }

    public function getSpecialDistribution(): ?string
    {
        return $this->specialDistribution;
    }

    public function setSpecialDistribution(?string $specialDistribution): self
    {
        $this->specialDistribution = $specialDistribution;

        return $this;
    }

    public function getExtNumberWay(): ?string
    {
        return $this->extNumberWay;
    }

    public function setExtNumberWay(?string $extNumberWay): self
    {
        $this->extNumberWay = $extNumberWay;

        return $this;
    }

    public function getNumberWay(): ?int
    {
        return $this->numberWay;
    }

    public function setNumberWay(?int $numberWay): self
    {
        $this->numberWay = $numberWay;

        return $this;
    }

    public function getTypeWay(): ?string
    {
        return $this->typeWay;
    }

    public function setTypeWay(?string $typeWay): self
    {
        $this->typeWay = $typeWay;

        return $this;
    }

    public function getWay(): ?string
    {
        return $this->way;
    }

    public function setWay(?string $way): self
    {
        $this->way = $way;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }








    public function getPictureFolder(): ?array
    {
        return $this->pictureFolder;
    }

    public function setPictureFolder(?array $pictureFolder): self
    {
        $this->pictureFolder = $pictureFolder;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getAverageRate(): ?int
    {
        return $this->averageRate;
    }

    public function setAverageRate(?int $averageRate): self
    {
        $this->averageRate = $averageRate;

        return $this;
    }

    public function getIsReported(): ?bool
    {
        return $this->isReported;
    }

    public function setIsReported(bool $isReported): self
    {
        $this->isReported = $isReported;

        return $this;
    }

    public function getCreatedAt()
    {
        if ($this->createdAt != NULL) {
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
        if ($this->updatedAt != NULL) {
            return $this->updatedAt->format('d/m/Y H:i:s');
        }
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Advice[]
     */
    public function getAdvices(): Collection
    {
        return $this->advices;
    }

    public function addAdvice(Advice $advice): self
    {
        if (!$this->advices->contains($advice)) {
            $this->advices[] = $advice;
            $advice->setUserAuthor($this);
        }

        return $this;
    }

    public function removeAdvice(Advice $advice): self
    {
        if ($this->advices->contains($advice)) {
            $this->advices->removeElement($advice);
            // set the owning side to null (unless already changed)
            if ($advice->getUserAuthor() === $this) {
                $advice->setUserAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Advice[]
     */
    public function getAdvice(): Collection
    {
        return $this->advice;
    }

    /**
     * @return Collection|Rate[]
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setUserAuthor($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rates->contains($rate)) {
            $this->rates->removeElement($rate);
            // set the owning side to null (unless already changed)
            if ($rate->getUserAuthor() === $this) {
                $rate->setUserAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rate[]
     */
    public function getRate(): Collection
    {
        return $this->rate;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getEmailCreatedAt(): ?\DateTimeInterface
    {
        return $this->emailCreatedAt;
    }

    public function setEmailCreatedAt(?\DateTimeInterface $emailCreatedAt): self
    {
        $this->emailCreatedAt = $emailCreatedAt;

        return $this;
    }

    public function getPassCreatedAt(): ?\DateTimeInterface
    {
        return $this->passCreatedAt;
    }

    public function setPassCreatedAt(?\DateTimeInterface $passCreatedAt): self
    {
        $this->passCreatedAt = $passCreatedAt;

        return $this;
    }

    public function getPassToken(): ?string
    {
        return $this->passToken;
    }

    public function setPassToken(?string $passToken): self
    {
        $this->passToken = $passToken;

        return $this;
    }
}
