<?php

namespace App\Entity;

use App\Init\DateInit;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
     * @ORM\Column(type="datetime")
     */
    private $datecreate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateupdate;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="question", cascade={"remove"})
     */
    private $reponses;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $index_question;

    /**
     * @ORM\OneToMany(targetEntity=ChoisirReponse::class, mappedBy="question", orphanRemoval=true)
     */
    private $choisirReponses;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="questions")
     */
    private $category;

    public function __construct()
    {
        
        $this->reponses = new ArrayCollection();
        $this->init();
        $this->choisirReponses = new ArrayCollection();
    }

    private function init()
    {         
        $this->datecreate   = DateInit::dateNow();
        $this->dateupdate   = DateInit::dateNow();
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

    public function getDatecreate(): ?\DateTimeInterface
    {
        return $this->datecreate;
    }

    public function setDatecreate(\DateTimeInterface $datecreate): self
    {
        $this->datecreate = $datecreate;

        return $this;
    }

    public function getDateupdate(): ?\DateTimeInterface
    {
        return $this->dateupdate;
    }

    public function setDateupdate(\DateTimeInterface $dateupdate): self
    {
        $this->dateupdate = $dateupdate;

        return $this;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }

    public function getIndexQuestion(): ?int
    {
        return $this->index_question;
    }

    public function setIndexQuestion(int $index_question): self
    {
        $this->index_question = $index_question;

        return $this;
    }
    
    public function __toString(){
      return $this->libele;  
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
            $choisirReponse->setQuestion($this);
        }

        return $this;
    }

    public function removeChoisirReponse(ChoisirReponse $choisirReponse): self
    {
        if ($this->choisirReponses->removeElement($choisirReponse)) {
            // set the owning side to null (unless already changed)
            if ($choisirReponse->getQuestion() === $this) {
                $choisirReponse->setQuestion(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
