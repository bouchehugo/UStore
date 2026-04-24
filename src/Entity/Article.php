<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'article')]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_article', type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(name: 'id_categorie', referencedColumnName: 'id_categorie', nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\Column(name: 'reference', type: 'string', length: 50, unique: true)]
    private string $reference;

    #[ORM\Column(name: 'libelle', type: 'string', length: 150)]
    private string $libelle;

    #[ORM\Column(name: 'stock_actuel', type: 'integer', options: ['default' => 0])]
    private int $stockActuel = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getStockActuel(): int
    {
        return $this->stockActuel;
    }

    public function setStockActuel(int $stockActuel): self
    {
        $this->stockActuel = $stockActuel;

        return $this;
    }
}

