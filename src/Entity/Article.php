<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



//Création d'une nouvelle entité grâce à la fonctionnalité ORM de Doctrine
/**
 * @ORM\Entity()
 */

// Création d'une nouvelle classe au nom de la page
// Pour prendre en compte nos annotations qui seront prise en charge par l'ORM Doctrine
// Pour la création de tables, lignes colones

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

// creer le fichier de migration :
// php bin/ console make: migration

// le comparer avec la bdd & y faire des modifications
// php bin/ console doctrine:migrations:migrate