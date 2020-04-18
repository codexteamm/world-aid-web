<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('roles',ChoiceType::class,array('label'=>'Type',
                'choices'=>array('ADMIN' => 'ROLE_ADMIN',
                    'NECESSITEUX' => 'ROLE_NECESSITEUX',
                    'BENEVOLE' => 'ROLE_BENEVOLE',
                    'ASSOCIATION' => 'ROLE_ASSOCIATION'),
                'required' => true, 'multiple'=> true,
            ))
            ->add('nom')
            ->add('roles',ChoiceType::class,[
                'choices'=>['ADMIN' => 'ROLE_ADMIN',
                    'NECESSITEUX' => 'ROLE_NECESSITEUX',
                    'BENEVOLE' => 'ROLE_BENEVOLE',
                    'ASSOCIATION' => 'ROLE_ASSOCIATION',
                ],
                'required' => true, 'multiple'=> true,'expanded' => false,
            ] )

            ->add('prenom')
            ->add('pays')
            ->add('datenaissance',DateType::class,array("widget"=>"single_text","format"=>"yyyy-MM-dd"))
            ->add('descriptioncassocial')
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