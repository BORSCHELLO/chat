<?php

declare(strict_types=1);

namespace App\Profile\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add(
                'name',
                TextType::class,
                [
                    'attr' => ['class' => "form-control"]
                ]
            )->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Отправить',
                    'attr' => ['class' => "btn btn-success mt-2"]
                ]
            )
            ->getForm();
    }
}
