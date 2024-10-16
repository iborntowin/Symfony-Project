<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref', IntegerType::class)
            ->add('title', TextType::class)
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'username', // Make sure this property exists in your Author entity
            ])
            ->add('nbrPage', IntegerType::class)
            ->add('picture', FileType::class, [
                'label' => 'Picture (JPEG or PNG file)',
                'mapped' => false, // This should be false as you are not mapping this to a database field
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
