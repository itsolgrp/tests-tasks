<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("code", groups={"addUser"}, message="Töötaja selle koodiga on juba olemas!")
 * @UniqueEntity("username", groups={"addUser"}, message="Töötaja selle kasutajanimega on juba olemas!")
 * @UniqueEntity("personalCode", groups={"addUser"}, message="Töötaja selle isikukoodiga on juba olemas!")
 * @UniqueEntity("email", groups={"addUser"}, message="Töötaja selle emailiga on juba olemas!")
 * @ORM\Table(
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="unique_user_code",columns={"code"}),
 *          @ORM\UniqueConstraint(name="unique_user_username",columns={"username"}),
 *          @ORM\UniqueConstraint(name="unique_user_personalCode",columns={"personal_code"}),
 *          @ORM\UniqueConstraint(name="unique_user_email",columns={"email"}),
 *      }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(groups={"addUser"}, message="Kasutajanimi jäi sisestamata!")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

     /**
     * @Assert\NotBlank(groups={"addUser"}, message="Parool jäi sisestamata!")
     * @Assert\Length(groups={"addUser"}, max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(groups={"addUser"}, message="Kood jäi sisestamata!")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(groups={"addUser"}, message="Eesnimi jäi sisestamata!")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\NotBlank(groups={"addUser"}, message="Perekonnanimi jäi sisestamata!")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(groups={"addUser"}, message="Isikukood jäi sisestamata!")
     */
    private $personalCode;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank(groups={"addUser"}, message="Telefon jäi sisestamata!")
     * @Assert\Regex(groups={"addUser"}, pattern="/^[0-9\s]*$/", message="Vale telefon!")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=true)
     * @Assert\Regex(groups={"addUser"}, pattern="/^[a-zA-Z0-9.!#$%&'*+\=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/", message="Vale email!")
     */ 
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;


    public function __construct()
    {

    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = json_decode($this->roles);
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = json_encode($roles);

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

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

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
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCode(): ?string {
        return $this->code;
    }

    public function setCode(string $code): self {
        $this->code = $code;

        return $this;
    }

    public function getPosition(): ?string {
        return $this->position;
    }

    public function setPosition(string $position) {
        $this->position = $position;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPersonalCode(): ?string
    {
        return $this->personalCode;
    }

    public function setPersonalCode(string $personalCode): self
    {
        $this->personalCode = $personalCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection|Shift[]
     */
    public function getShifts(): Collection
    {
        return $this->shifts;
    }

    public function addShift(Shift $shift): self
    {
        if (!$this->shifts->contains($shift)) {
            $this->shifts[] = $shift;
            $shift->setUser($this);
        }

        return $this;
    }

    public function removeShift(Shift $shift): self
    {
        if ($this->shifts->contains($shift)) {
            $this->shifts->removeElement($shift);
            // set the owning side to null (unless already changed)
            if ($shift->getUser() === $this) {
                $shift->setUser(null);
            }
        }

        return $this;
    }
}
