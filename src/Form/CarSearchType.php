<?php

namespace App\Form;

use App\Entity\CarSearch;
use App\Entity\EnergyOption;
use App\Entity\Seat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('energyOption', EntityType::class, [
            'class' => EnergyOption::class, // choisir la class EnergyOption
            'choice_label' => 'name', // afficher le champ name des energies
            'multiple' => true,
            'attr' => array(
                'class' => 'form-control'
            ),
            'required' => false
        ]);
        $builder->add('seat', EntityType::class, [
            'class' => Seat::class,
            'choice_label' => 'quantity',
            'multiple' => true,
            'attr' => array(
                'class' => 'form-control'
            ),
            'required' => false
        ]);
        $builder->add('km', IntegerType::class, [
            'attr' => array(
                'class' => 'form-control',
            ),
            'required' => false
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarSearch::class,
        ]);
    }

    // cette methode retire le nom "car_search" sur le formulaire
    // car_search n'est donc plus dans $post, 
    // sans cette fonction : car_search est le parent des attributs energyOption, seat et km dans $post
    // public function getBlockPrefix() {
    //     return '';
    // }

}
