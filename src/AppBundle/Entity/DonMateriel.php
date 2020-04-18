<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DonMateriel
 *
 * @ORM\Table(name="don_materiel", indexes={@ORM\Index(name="id_association", columns={"id_association"}), @ORM\Index(name="id_benevole", columns={"id_benevole"}), @ORM\Index(name="id_evenement", columns={"id_evenement"})})
 * @ORM\Entity
 */
class DonMateriel
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_don", type="date", nullable=false)
     */
    private $dateDon;

    /**
     * @var string
     *
     * @ORM\Column(name="type_materiel", type="string", length=50, nullable=false)
     */
    private $typeMateriel;

    /**
     * @var float
     *
     * @ORM\Column(name="quantite", type="float", precision=10, scale=0, nullable=false)
     */
    private $quantite;

    /**
     * @var integer
     *
     * @ORM\Column(name="reference", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reference;

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
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_benevole", referencedColumnName="id")
     * })
     */
    private $idBenevole;

    /**
     * @var \AppBundle\Entity\Evenement
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_evenement", referencedColumnName="id_event")
     * })
     */
    private $idEvenement;

    /**
     * @return \DateTime
     */
    public function getDateDon()
    {
        return $this->dateDon;
    }

    /**
     * @param \DateTime $dateDon
     */
    public function setDateDon($dateDon)
    {
        $this->dateDon = $dateDon;
    }

    /**
     * @return string
     */
    public function getTypeMateriel()
    {
        return $this->typeMateriel;
    }

    /**
     * @param string $typeMateriel
     */
    public function setTypeMateriel($typeMateriel)
    {
        $this->typeMateriel = $typeMateriel;
    }

    /**
     * @return float
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param float $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param int $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
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
     * @return User
     */
    public function getIdBenevole()
    {
        return $this->idBenevole;
    }

    /**
     * @param User $idBenevole
     */
    public function setIdBenevole($idBenevole)
    {
        $this->idBenevole = $idBenevole;
    }

    /**
     * @return Evenement
     */
    public function getIdEvenement()
    {
        return $this->idEvenement;
    }

    /**
     * @param Evenement $idEvenement
     */
    public function setIdEvenement($idEvenement)
    {
        $this->idEvenement = $idEvenement;
    }




}

