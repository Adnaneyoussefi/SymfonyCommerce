<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

class Categorie
{
    /**
     * @Groups("categorie")
     */
    private $id;

    /**
     * @Groups("categorie")
     */
    private $nom;
    
    /**
     * @Groups("produits")
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

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

    /**
     * @return Collection|Produit[]
     */
    public function getProduits()
    {
        return $this->produits;
    }

    public function setProduits(array $produits): self
    {
        $this->produits = $produits;

        return $this;
    }

    public function addProduit(Produit $produit): self
    {
        $this->produits[] = $produit;
        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCategorie() === $this) {
                $produit->setCategorie(null);
            }
        }
        return $this;
    }
    public function __toString() {
        return $this->nom;
    }
}
