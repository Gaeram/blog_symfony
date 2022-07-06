<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



//Création d'une nouvelle entité grâce à la fonctionnalité ORM de Doctrine
/**
 * @ORM\Entity()
 */

// Création d'une nouvelle classe au nom de la page
// Pour y noter nos ORM mappés qui vont permettre la création de tables
class Article
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $title;
}