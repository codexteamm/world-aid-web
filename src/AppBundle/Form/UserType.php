<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mdp')
            ->add('type')
            ->add('nom')
            ->add('prenom')
            ->add('pays')
            ->add('mail')
            ->add('datenaissance')
            ->add('descriptioncassocial')
            ->add('valide')
            ->add('nomassociaiton')
            ->add('rib')
            ->add('addresse')
            ->add('categorie')
            ->add('logo')
            ->add('numero');
            //->add('idcampementnull')
            //->add('idevenement')
            //->add('idcampement');

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
        //return 'appbundle_user'; sofien
        //return 'AppBundle_user';
    }


}
