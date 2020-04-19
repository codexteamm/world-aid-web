<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="id_association", columns={"id_association"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom_event", type="string", length=30, nullable=false)
     */
    private $nomEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut_event", type="date", nullable=true)
     */
    private $dateDebutEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_event", type="date", nullable=false)
     */
    private $dateFinEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=20, scale=9, nullable=false)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=20, scale=9, nullable=false)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=30, nullable=true)
     */
    private $categorie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creer_le", type="datetime", nullable=false)
     */
    private $creerLe ;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_event", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\donMateriel", mappedBy="idevenement")
     */
    private $reference;

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $reference
     */
    public function setReference($reference)
    {
        $this->reference ;
        $this->reference ;
            }


    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_association", referencedColumnName="id")
     * })
     */
    private $idAssociation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", mappedBy="idevenement")
     */
    private $idbenevole;

    /**
     * @return string
     */
    public function getNomEvent()
    {
        return $this->nomEvent;
    }

    /**
     * @param string $nomEvent
     */
    public function setNomEvent($nomEvent)
    {
        $this->nomEvent = $nomEvent;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebutEvent()
    {
        return $this->dateDebutEvent;
    }

    /**
     * @param \DateTime $dateDebutEvent
     */
    public function setDateDebutEvent($dateDebutEvent)
    {
        $this->dateDebutEvent = $dateDebutEvent;
    }

    /**
     * @return \DateTime
     */
    public function getDateFinEvent()
    {
        return $this->dateFinEvent;
    }

    /**
     * @param \DateTime $dateFinEvent
     */
    public function setDateFinEvent($dateFinEvent)
    {
        $this->dateFinEvent = $dateFinEvent;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
    public function getCreerLe()
    {
        return $this->creerLe;
    }

    /**
     * @param \DateTime $creerLe
     */
    public function setCreerLe($creerLe)
    {
        $this->creerLe = $creerLe;
    }

    /**
     * @return int
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * @param int $idEvent
     */
    public function setIdEvent($idEvent)
    {
        $this->idEvent = $idEvent;
    }

    /**
     * @return User
     */
    public function getIdAssociation()
    {
        return $this->idAssociation;
    }

    /**
     * @param User $idAssociation
     */
    public function setIdAssociation($idAssociation)
    {
        $this->idAssociation = $idAssociation;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdbenevole()
    {
        return $this->idbenevole;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idbenevole
     */
    public function setIdbenevole($idbenevole)
    {
        $this->idbenevole = $idbenevole;
    }

    /**
     * @ORM\OneToMany(targetEntity="BenevoleBundle\Entity\Eventfeedback", mappedBy="idevenement")
     */
    private $eventfeedback;

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getEventfeedback()
    {
        return $this->eventfeedback;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $eventfeedback
     */
    public function setEventfeedback($eventfeedback)
    {
        $this->eventfeedback = $eventfeedback;
    }

    /**
     * Constructor
     */

    public function __construct()
    {
        $this->idbenevole = new \Doctrine\Common\Collections\ArrayCollection();
        $this->eventfeedback = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creerLe = new \DateTime('now');
    }

}

