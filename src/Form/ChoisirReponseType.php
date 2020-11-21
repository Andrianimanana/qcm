<?php

namespace App\Form;

use App\Entity\ChoisirReponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoisirReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        #$builder
            #->add('date')
            #->add('user')
            #->add('reponse')
        #;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChoisirReponse::class,
        ]);
    }
}
