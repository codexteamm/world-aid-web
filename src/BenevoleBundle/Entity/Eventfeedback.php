<?php

namespace BenevoleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eventfeedback
 *
 * @ORM\Table(name="eventfeedback")
 * @ORM\Entity(repositoryClass="BenevoleBundle\Repository\EventfeedbackRepository")
 */
class Eventfeedback
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=255)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;



    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Evenement", inversedBy="eventfeedback")
     * @ORM\JoinColumn(name="idevenement", referencedColumnName="id_event")
     */
    private $idevenement;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="eventfeedback")
     * @ORM\JoinColumn(name="idbenevole", referencedColumnName="id")
     */
    private $idbenevole;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     *
     * @return Eventfeedback
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Eventfeedback
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getIdevenement()
    {
        return $this->idevenement;
    }

    /**
     * @param mixed $idevenement
     */
    public function setIdevenement($idevenement)
    {
        $this->idevenement = $idevenement;
    }

    /**
     * @return mixed
     */
    public function getIdbenevole()
    {
        return $this->idbenevole;
    }

    /**
     * @param mixed $idbenevole
     */
    public function setIdbenevole($idbenevole)
    {
        $this->idbenevole = $idbenevole;
    }

}

