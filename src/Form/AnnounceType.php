<?php

namespace App\Form;

use App\Entity\Announce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnounceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('description', TextareaType::class, [
                "attr" => [
                    "class" => "form-control" 
                ]
            ])
            ->add('price', NumberType::class, [
                "attr" => [
                    "class" => "form-control" 
                ]
            ])
            ->add('address', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('coverImage', FileType::class)
            ->add('rooms', NumberType::class, [
                "attr" => [
                    "class" => "form-control" 
                ]
            ])
            ->add('isAvailable', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announce::class,
        ]);
    }
}
