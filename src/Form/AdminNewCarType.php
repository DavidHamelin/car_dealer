<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\EnergyOption;
use App\Entity\Seat;
use App\Entity\TypeOfSale;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AdminNewCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('brand', TextType::class, [
            'attr' => array(
                'class' => 'form-control'
            ),
            'required' => false
        ]);
        $builder->add('model', TextType::class, [
            'attr' => array(
                'class' => 'form-control'
            ),
            'required' => false
        ]);
        $builder->add('year', NumberType::class, [
            'attr' => array(
                'class' => 'form-control'
            ),
            'required' => false
        ]);
        $builder->add('engine', TextType::class, [
            'attr' => array(
                'class' => 'form-control'
            ),
            'required' => false
        ]);
        $builder->add('color', TextType::class, [
            'attr' => array(
                'class' => 'form-control'
            ),
            'required' => false
        ]);
        $builder->add('energyOptions', EntityType::class, [
            'class' => EnergyOption::class, // choisir la class EnergyOption
            'choice_label' => 'name', // afficher le champ name des energies
            'multiple' => true,
            'expanded' => true,
            'attr' => array(
                'class' => 'form-control'
            ),
            'required' => false
        ]);
        $builder->add('seat', EntityType::class, [
            'class' => Seat::class,
            'choice_label' => 'quantity',
            // 'multiple' => true, : non multiple ici
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
        $builder->add('typeOfSale', EntityType::class, [
            'class' => TypeOfSale::class,
            'choice_label' => 'name',
            // 'multiple' => true, : non multiple ici
            'attr' => array(
                'class' => 'form-control'
            ),
            'required' => false
        ]);
        $builder->add('imageFile', VichImageType::class, [
            'required' => false,
            'label' => 'Attached picture',
            // 'allow_delete' => true,
            // 'delete_label' => '...',
            // 'download_label' => '...',
            // 'download_uri' => true,
            // 'image_uri' => true,
            // 'imagine_pattern' => '...',
            // 'asset_helper' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
