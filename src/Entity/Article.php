<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @UniqueEntity("title", message="Ce titre existe déja tête de con")
 */
// Création d'une nouvelle classe au nom de la page
class Article
{
    // Pour prendre en compte nos annotations qui seront prise en charge par l'ORM Doctrine
    // Pour la création de tables, lignes colones
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\IsNull(message="Ton titre tocard")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    // La relation ManyToOne Créée une clé étrangère permettant de lier
    // articles & catégories correspondantes
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ArticleCategory")
     */

    private $category;

    public function getId (): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }



    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }




    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

}

// creer le fichier de migration :
// php bin/ console make: migration
// le comparer avec la bdd & y faire des modifications
// php bin/ console doctrine:migrations:migrate
// creer nouvelle entité :
// php bin/console make:entity