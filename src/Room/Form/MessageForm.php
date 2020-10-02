<?php

declare(strict_types=1);

namespace App\Room\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return $builder
            ->add('message',
                TextareaType::class,
                [
                    'label'  => false,
                    'attr' => ['class' => "form-control",'rows'=>"3"]
                ]
            )->add(
                'save',
                ButtonType::class,
                [
                    'label' => 'Отправить',
                    'attr' => ['class' => "btn btn-secondary mt-2"]
                ]
            )
            ->getForm();
    }
}