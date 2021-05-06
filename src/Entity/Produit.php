<?php

namespace App\Entity;

use App\Entity\Categorie;
use Symfony\Component\Serializer\Annotation\Groups;

class Produit
{
    /**
     * @Groups("produit")
     */
    private int $id;

    /**
     * @Groups("produit")
     */
    private string $nom;

    /**
     * @Groups("produit")
     */
    private string $description;

    /**
     * @Groups("produit")
     */
    private float $prix;

    /**
     * @Groups("produit")
     */
    private string $image;

    /**
     * @Groups("produit")
     */
    private int $quantite;

    /**
     * @Groups("categorie")
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
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
}
