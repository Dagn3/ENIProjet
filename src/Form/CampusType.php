<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class CampusType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
$builder
->add('nom', ChoiceType::class, ['label'=> 'Campus', 'choices'=> [
    'saint herblain' => 'saint herblain',
    'chartres de bretagne' => 'chartre de bretagne',
    'la roche sur yon' => 'la roche sur yon'
],
    'multiple'=>false
])


;
}




public function configureOptions(OptionsResolver $resolver): void
{
$resolver->setDefaults([
'data_class' => Campus::class



]);
}
}