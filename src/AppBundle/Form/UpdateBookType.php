<?php

namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateBookType extends BookType
{

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
    }

    public function getName()
    {
        return 'book_edit';
    }
}