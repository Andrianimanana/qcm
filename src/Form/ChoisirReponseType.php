<?php

namespace App\Form;

use App\Entity\ChoisirReponse;
use App\Entity\Question;
use App\Entity\Reponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoisirReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { 
        $reponse    = $options["reponses"];
        $question   = $options["question"];

        $builder
            ->add('reponse', EntityType::class, [
                'class'         => Reponse::class,
                'choices'       => $reponse,
                'choice_label'  => 'libele',
                'required'      => false,
                'expanded'      => true, // radio bouton 
            ])
            ->add('question', EntityType::class, [
                'class'     => Question::class,
                'choices'   => $question,
                'attr'      => ["class" => "hidden"]
            ]) // @toDo create a custom field form Type
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'    => ChoisirReponse::class,
            'reponses'      => Reponse::class,
            'question'      => Question::class,
        ]);
    }
}
