<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="facebook_id",type="string", length=255, nullable=true)
     */
    protected $facebook_id;

    /**
     * @ORM\Column(name="facebook_access_token",type="string", length=255, nullable=true)
     */
    protected $facebook_access_token;


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
     * @ORM\Column(name="idcampementnull", type="integer", nullable=true)
     */
    private $idcampementnull;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected  $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Evenement", inversedBy="idbenevole")
     * @ORM\JoinTable(name="benevoler",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idBenevole", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idEvenement", referencedColumnName="id_event")
     *   }
     * )
     */
    private $idevenement;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Campement", inversedBy="idassociation")
     * @ORM\JoinTable(name="prendreencharge",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idassociation", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idcampement", referencedColumnName="id")
     *   }
     * )
     */
    private $idcampement;

    /**
     * @return string
     */
    public function getAddresse()
    {
        return $this->addresse;
    }

    /**
     * @param string $addresse
     */
    public function setAddresse($addresse)
    {
        $this->addresse = $addresse;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return \DateTime
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }

    /**
     * @param \DateTime $datenaissance
     */
    public function setDatenaissance($datenaissance)
    {
        $this->datenaissance = $datenaissance;
    }

    /**
     * @return string
     */
    public function getDescriptioncassocial()
    {
        return $this->descriptioncassocial;
    }

    /**
     * @param string $descriptioncassocial
     */
    public function setDescriptioncassocial($descriptioncassocial)
    {
        $this->descriptioncassocial = $descriptioncassocial;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return int
     */
    public function getIdcampementnull()
    {
        return $this->idcampementnull;
    }

    /**
     * @param int $idcampementnull
     */
    public function setIdcampementnull($idcampementnull)
    {
        $this->idcampementnull = $idcampementnull;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdevenement()
    {
        return $this->idevenement;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idevenement
     */
    public function setIdevenement($idevenement)
    {
        $this->idevenement = $idevenement;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdcampement()
    {
        return $this->idcampement;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idcampement
     */
    public function setIdcampement($idcampement)
    {
        $this->idcampement = $idcampement;
    }

    public function addcampement(Campement $campement)
    {
        if ($this->idcampement->contains($campement)) {
            return;
        }
        $this->idcampement[] = $campement;

        return $this;
    }
    public function removecampement(Campement $campement)
    {
        if ($this->idcampement->contains($campement)) {
            $this->idcampement->removeElement($campement);

        }

        return $this;
    }



    /**
     * @return string
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * @param string $mdp
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getNomassociaiton()
    {
        return $this->nomassociaiton;
    }

    /**
     * @param string $nomassociaiton
     */
    public function setNomassociaiton($nomassociaiton)
    {
        $this->nomassociaiton = $nomassociaiton;
    }

    /**
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return bool
     */
    public function isValide()
    {
        return $this->valide;
    }

    /**
     * @param bool $valide
     */
    public function setValide($valide)
    {
        $this->valide = $valide;
    }

    /**
     * @return string
     */
    public function getRib()
    {
        return $this->rib;
    }

    /**
     * @param string $rib
     */
    public function setRib($rib)
    {
        $this->rib = $rib;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->idevenement = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idcampement = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

