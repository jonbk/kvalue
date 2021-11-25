<?php

namespace App\Form;

use App\Form\Model\SpaceForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class SpaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['constraints' =>
                [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^[a-z_\-]+$/i',
                        'htmlPattern' => '[a-z_\-]+',
                        'message' => 'Only a-z, _ and - are accepted'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SpaceForm::class,
            'csrf_protection' => false
        ]);
    }
}
