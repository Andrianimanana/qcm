<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReponseRepository::class)
 */
class Reponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $libele;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_true;

    /**
     * @ORM\OneToMany(targetEntity=ChoisirReponse::class, mappedBy="reponse")
     */
    private $choisirReponses;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="reponses")
     */
    private $question;

    public function __construct()
    {
        $this->choisirReponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibele(): ?string
    {
        return $this->libele;
    }

    public function setLibele(string $libele): self
    {
        $this->libele = $libele;

        return $this;
    }

    public function getIsTrue(): ?bool
    {
        return $this->is_true;
    }

    public function setIsTrue(bool $is_true): self
    {
        $this->is_true = $is_true;

        return $this;
    }

    /**
     * @return Collection|ChoisirReponse[]
     */
    public function getChoisirReponses(): Collection
    {
        return $this->choisirReponses;
    }

    public function addChoisirReponse(ChoisirReponse $choisirReponse): self
    {
        if (!$this->choisirReponses->contains($choisirReponse)) {
            $this->choisirReponses[] = $choisirReponse;
            $choisirReponse->setReponse($this);
        }

        return $this;
    }

    public function removeChoisirReponse(ChoisirReponse $choisirReponse): self
    {
        if ($this->choisirReponses->removeElement($choisirReponse)) {
            // set the owning side to null (unless already changed)
            if ($choisirReponse->getReponse() === $this) {
                $choisirReponse->setReponse(null);
            }
        }

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
