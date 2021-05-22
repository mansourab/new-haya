<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Owner;
use App\Entity\Property;
use App\Entity\Quarter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PropertyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'Property Title'
            ])
            ->add('content', TextareaType::class, [
                'required' => false,
                'label' => 'Property Description'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => false,
            ])
            ->add('categories', EntityType::class, [
                'required' => false,
                'label' => 'Choose Categories',
                'class' => Category::class,
                // 'expanded' => true,
                'multiple' => true,
            ])
            ->add('quarter', EntityType::class, [
                'required' => false,
                'label' => 'Lieu',
                'class' => Quarter::class,
            ])
            ->add('owner', EntityType::class, [
                'required' => false,
                'label' => 'Le propriétaire',
                'class' => Owner::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
