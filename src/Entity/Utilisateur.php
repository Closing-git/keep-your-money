<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $argentPossede = null;

    /**
     * @var Collection<int, Accessoire>
     */
    #[ORM\ManyToMany(targetEntity: Accessoire::class, inversedBy: 'utilisateursQuiPossedent')]
    #[ORM\JoinTable(name: 'utilisateur_possession')]
    #[ORM\JoinColumn(name: 'utilisateur_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'accessoire_id', referencedColumnName: 'id')]
    private Collection $possession;

    /**
     * @var Collection<int, Accessoire>
     */
    #[ORM\ManyToMany(targetEntity: Accessoire::class)]
    #[ORM\JoinTable(name: 'utilisateur_tenue_portee')]
    #[ORM\JoinColumn(name: 'utilisateur_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'accessoire_id', referencedColumnName: 'id')]
    private Collection $tenuePortee;

    public function __construct()
    {
        $this->possession = new ArrayCollection();
        $this->tenuePortee = new ArrayCollection();
        $this->argentPossede = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getArgentPossede(): ?int
    {
        return $this->argentPossede;
    }

    public function setArgentPossede(int $argentPossede): static
    {
        $this->argentPossede = $argentPossede;

        return $this;
    }

    /**
     * @return Collection<int, Accessoire>
     */
    public function getPossession(): Collection
    {
        return $this->possession;
    }

    public function addPossession(Accessoire $possession): static
    {
        if (!$this->possession->contains($possession)) {
            $this->possession->add($possession);
        }

        return $this;
    }

    public function removePossession(Accessoire $possession): static
    {
        $this->possession->removeElement($possession);

        return $this;
    }

    /**
     * @return Collection<int, Accessoire>
     */
    public function getTenuePortee(): Collection
    {
        return $this->tenuePortee;
    }

    public function addTenuePortee(Accessoire $tenuePortee): static
    {
        if (!$this->tenuePortee->contains($tenuePortee)) {
            $this->tenuePortee->add($tenuePortee);
        }

        return $this;
    }

    public function removeTenuePortee(Accessoire $tenuePortee): static
    {
        $this->tenuePortee->removeElement($tenuePortee);

        return $this;
    }
}
