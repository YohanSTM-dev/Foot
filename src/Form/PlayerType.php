<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Level;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Photo')
            ->add('DateDeNaissance')
            ->add('Niveau', EntityType::class, [
                'class' => Level::class,
                'choice_label' => 'nom',
            ])
            ->add('CategorieSportive', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
