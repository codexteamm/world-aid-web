<?php

namespace NecessiteuxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * DemandeAide
 *
 * @ORM\Table(name="demande_aide", indexes={@ORM\Index(name="id_cassocial", columns={"id_cassocial"})})
 * @ORM\Entity
 */
class DemandeAide implements NotifiableInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="id_demande", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDemande;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return DemandeAide
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return DemandeAide
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return DemandeAide
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Get idDemande
     *
     * @return integer
     */
    public function getIdDemande()
    {
        return $this->idDemande;
    }

    /**
     * Set idCassocial
     *
     * @param \AppBundle\Entity\User $idCassocial
     *
     * @return DemandeAide
     */
    public function setIdCassocial( $idCassocial)
    {
        $this->idCassocial = $idCassocial;

        return $this;
    }

    /**
     * Get idCassocial
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdCassocial()
    {
        return $this->idCassocial;
    }

    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle('New request')
            ->setDescription($this->titre)
            ->setRoute('readnotif')
            ->setParameters(array('id' => $this->idDemande))
        ;
        $builder->addNotification($notification);
        return $builder;
        // TODO: Implement notificationsOnCreate() method.
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle('Request modified')
            ->setDescription($this->titre)
            ->setRoute('readnotif')
            ->setParameters(array('id' => $this->idDemande))
        ;
        $builder->addNotification($notification);
        return $builder;
        // TODO: Implement notificationsOnUpdate() method.
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle('Request deleted')
            ->setDescription($this->titre)
            ->setRoute('readnotif')
            ->setParameters(array('id' => $this->idDemande))
        ;
        $builder->addNotification($notification);
        return $builder;
        // TODO: Implement notificationsOnDelete() method.
    }


}
