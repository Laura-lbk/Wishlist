<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="personne")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\OneToOne(targetEntity=User::class, orphanRemoval=true)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Cadeau::class, mappedBy="personne", cascade={"persist"})
     */
    private $cadeaux;

    public function __toString(){
        return $this->nom . ' '. $this->prenom;
    }

    public function __construct()
    {
        $this->cadeaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

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

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Cadeau[]
     */
    public function getCadeaux(): Collection
    {
        return $this->cadeaux;
    }

    public function addCadeaux(Cadeau $cadeaux): self
    {

            $this->cadeaux[] = $cadeaux;
            $cadeaux->setPersonne($this);
    

        return $this;
    }

    public function removeCadeaux(Cadeau $cadeaux): self
    {
        if ($this->cadeaux->removeElement($cadeaux)) {
            // set the owning side to null (unless already changed)
            if ($cadeaux->getPersonne() === $this) {
                $cadeaux->setPersonne(null);
            }
        }

        return $this;
    }
}
