<?php


namespace AssociationBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class evenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomEvent')
            ->add('dateDebutEvent',DateType::class,array("widget"=>"single_text","format"=>"yyyy-MM-dd"))
            ->add('dateFinEvent', DateType::class,array("widget"=>"single_text","format"=>"yyyy-MM-dd"))
            ->add('longitude',HiddenType::class)
            ->add('latitude',HiddenType::class)
            ->add('description')
            ->add('categorie', ChoiceType::class, array(
                'choices'  => array(
                    'Femmes' => "Femmes",
                    'Enfants' => "Enfants",
                    'SDF' => "SDF",
                    'Refugie' => "Refugie",
                )));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_evenement';
    }



}