<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Article
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\id()
     * @ORM\GeneredValue
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $title; 
}