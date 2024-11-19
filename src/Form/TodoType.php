<?php

namespace App\Form;

use App\Entity\Todo;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];  // Dobijamo korisnika iz opcija koje smo prosledili

        $builder
            ->add('title')
            ->add('description')
            ->add('dueDate', null, [
                'widget' => 'single_text',
                'required' => true,
            ])
            // ->add('isFinished', CheckboxType::class, [
            //     'required' => false, // Checkbox je opcionalan
            // ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $user) {
                    return $user->getEmail(); // Prikazivanje emaila korisnika
                },
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('u')
                        ->where('u.id = :userId')
                        ->setParameter('userId', $user->getId());  // Filtriraj po ID-u trenutnog korisnika
                },
                'data' => $user, // Korisnik je već postavljen ovde
                'disabled' => true, // Možete isključiti ovo polje, jer je korisnik već postavljen u kontroleru
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
            'user' => null,  // Dodajemo opciju za prosleđivanje korisnika
        ]);
    }
}

