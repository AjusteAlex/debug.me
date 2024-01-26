<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('title', TextType::class, [
            'label' => 'Titre',
            'attr' => ['class' => "rounded"],
        ])
            ->add(
                'content',
                TextareaType::class,
                [
                    'attr' => ['class' => "rounded"],
                    'label' => 'Contenu'
                ]
            )
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
                'attr' => ['class' => "mr-6"],
                // used to render a select box, check boxes or radios
                'multiple' => true, 'expanded' => true,
                'label' => 'Tag(s)'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Ticket::class]);
    }
}
