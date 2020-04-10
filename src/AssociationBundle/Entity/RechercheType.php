<?php

namespace AssociationBundle\Entity;

/**
 * Contact
 */
class RechercheType
{
    /**
     * @var string|null
     */
    private $nom;

    /**
     * @var string|null
     */
    private $paye;

    /**
     * @return string|null
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string|null
     */
    public function getPaye()
    {
        return $this->paye;
    }

    /**
     * @param string|null $paye
     */
    public function setPaye($paye)
    {
        $this->paye = $paye;
    }


}
