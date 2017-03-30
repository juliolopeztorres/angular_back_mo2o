<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('author', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('resume', 'Symfony\Component\Form\Extension\Core\Type\TextareaType')
            ->add('isbn', 'Symfony\Component\Form\Extension\Core\Type\TextType')
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Book',
        ));
    }

    public function getName()
    {
        return 'book';
    }
}