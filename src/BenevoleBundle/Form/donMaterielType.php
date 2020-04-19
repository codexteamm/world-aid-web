<?php


namespace BenevoleBundle\Form;

use AppBundle\Entity\DonMateriel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use BenevoleBundle\Form\StringToArrayTransformer;




class donMaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('typeMateriel', ChoiceType::class, array(
                'choices'  => array(
                    'Vetements' => "Vetements",
                    'Alimentations' => "Alimentations",
                    'Medicaments' => "Medicaments",
                    'Equipements' => "Equipements",
                )))
            ->add('quantite')
            ->add('ajouter',SubmitType::class,['label'=>'Ajouter Don']);
        //->add('idcampementnull')
        //->add('idevenement')
        //->add('idcampement');
    }



    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DonMateriel'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'AppBundle_DonMateriel';
    }

}