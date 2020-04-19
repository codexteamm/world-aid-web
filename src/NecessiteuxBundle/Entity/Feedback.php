<?php

namespace NecessiteuxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feedback
 *
 * @ORM\Table(name="feedback", indexes={@ORM\Index(name="id_cassocial", columns={"id_cassocial"})})
 * @ORM\Entity
 */
class Feedback
{
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=200, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=500, nullable=false)
     */
    private $message;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="id_feedback", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFeedback;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cassocial", referencedColumnName="id")
     * })
     */
    private $idCassocial;

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return int
     */
    public function getIdFeedback()
    {
        return $this->idFeedback;
    }

    /**
     * @param int $idFeedback
     */
    public function setIdFeedback($idFeedback)
    {
        $this->idFeedback = $idFeedback;
    }

    /**
     * @return \AppBundle\Entity\User
     */
    public function getIdCassocial()
    {
        return $this->idCassocial;
    }

    /**
     * @param \AppBundle\Entity\User $idCassocial
     */
    public function setIdCassocial($idCassocial)
    {
        $this->idCassocial = $idCassocial;
    }



}

