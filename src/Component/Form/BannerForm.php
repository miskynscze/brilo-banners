<?php

namespace App\Component\Form;

use App\Entity\Banner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BannerForm extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Banner::class,
            'require_file' => false
        ]);

        $resolver->setAllowedTypes('require_file', 'bool');

        parent::configureOptions($resolver);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'mapped' => false,
                'required' => $options['require_file'],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'application/png',
                            'image/jpeg',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Prosím nahrajte pouze podporované formáty (png, jpeg, jpg)'
                    ])
                ]
            ])
            ->add('datePublish', DateType::class, [
                'required' => false
            ])
            ->add('dateUnpublish', DateType::class, [
                'required' => false
            ])
            ->add('showDuration', NumberType::class, [
                'required' => true,
                'attr' => [
                    'min' => 1
                ]
            ])
            ->add('published', CheckboxType::class, [
                'required' => false
            ])
            ->add('save', SubmitType::class);
    }
}