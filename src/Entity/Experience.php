<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ExperienceRepository::class)
 */
class Experience
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name_company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_company;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name_job;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $type_contrat;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $duree_contrat;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $ville;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCompany(): ?string
    {
        return $this->name_company;
    }

    public function setNameCompany(string $name_company): self
    {
        $this->name_company = $name_company;

        return $this;
    }

    public function getImageCompany(): ?string
    {
        return $this->image_company;
    }

    public function setImageCompany(?string $image_company): self
    {
        $this->image_company = $image_company;

        return $this;
    }

    public function getNameJob(): ?string
    {
        return $this->name_job;
    }

    public function setNameJob(string $name_job): self
    {
        $this->name_job = $name_job;

        return $this;
    }

    public function getTypeContrat(): ?string
    {
        return $this->type_contrat;
    }

    public function setTypeContrat(string $type_contrat): self
    {
        $this->type_contrat = $type_contrat;

        return $this;
    }

    public function getDureeContrat(): ?string
    {
        return $this->duree_contrat;
    }

    public function setDureeContrat(string $duree_contrat): self
    {
        $this->duree_contrat = $duree_contrat;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }
}
