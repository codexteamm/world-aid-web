<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Login
 *
 * @ORM\Table(name="login")
 * @ORM\Entity
 */
class Login
{
    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=30, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=30, nullable=true)
     */
    private $mdp;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=30, nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=30, nullable=true)
     */
    private $mail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=true)
     */
    private $datenaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionCasSocial", type="string", length=300, nullable=true)
     */
    private $descriptioncassocial;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valide", type="boolean", nullable=true)
     */
    private $valide;

    /**
     * @var string
     *
     * @ORM\Column(name="nomAssociaiton", type="string", length=30, nullable=true)
     */
    private $nomassociaiton;

    /**
     * @var string
     *
     * @ORM\Column(name="rib", type="string", length=30, nullable=true)
     */
    private $rib;

    /**
     * @var string
     *
     * @ORM\Column(name="addresse", type="string", length=30, nullable=true)
     */
    private $addresse;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=30, nullable=true)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=50, nullable=true)
     */
    private $logo;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="idcampement", type="integer", nullable=true)
     */
    private $idcampement;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


}

