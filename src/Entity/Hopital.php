<?php

namespace App\Entity;

use App\Repository\HopitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HopitalRepository::class)]
class Hopital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFabrication = null;

    /**
     * @var Collection<int, Medecin>
     */
    #[ORM\OneToMany(targetEntity: Medecin::class, mappedBy: 'hopital',cascade: ['remove'])]
    private Collection $medecin;

    public function __construct()
    {
        $this->medecin = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateFabrication(): ?\DateTimeInterface
    {
        return $this->dateFabrication;
    }

    public function setDateFabrication(\DateTimeInterface $dateFabrication): static
    {
        $this->dateFabrication = $dateFabrication;

        return $this;
    }

    /**
     * @return Collection<int, Medecin>
     */
    public function getMedecin(): Collection
    {
        return $this->medecin;
    }

    public function addMedecin(Medecin $medecin): static
    {
        if (!$this->medecin->contains($medecin)) {
            $this->medecin->add($medecin);
            $medecin->setHopital($this);
        }

        return $this;
    }

    public function removeMedecin(Medecin $medecin): static
    {
        if ($this->medecin->removeElement($medecin)) {
            // set the owning side to null (unless already changed)
            if ($medecin->getHopital() === $this) {
                $medecin->setHopital(null);
            }
        }

        return $this;
    }
}
