<?php


namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            // Add more fields as necessary
            ->add('save', SubmitType::class, [
                'label' => 'Add Book',
            ]);
    }
}
