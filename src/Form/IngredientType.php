<?php

namespace App\Form;

use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;


class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => '2',
                'maxlength' => '50'
            ],
            'label' => 'Nom',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank()
            ]
        ])
            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive,
                    new Assert\NotNull(),
                    new Assert\LessThan(200)
                ]
            ])
            ->add('submit',  SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Créer mon ingrédient',
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $ingredient = $event->getData();
                $form = $event->getForm();

                // vérifie si l'objet Ingredient est "nouveau"
                // Si aucune donnée n'est passée au formulaire, la donnée est "nulle".
                // Ceci doit être considéré comme un nouvelle "ingredient"
                if (!$ingredient || null === $ingredient->getId()) {
                    $form->add('submit', SubmitType::class, [
                        'attr' => [
                            'class' => 'btn btn-primary mt-4'
                        ],
                        'label' => 'Créer mon ingrédient',
                    ]);
                } else {
                    $form->add('submit', SubmitType::class, [
                        'attr' => [
                            'class' => 'btn btn-primary mt-4'
                        ],
                        'label' => 'Modifier mon ingrédient',
                    ]);
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
