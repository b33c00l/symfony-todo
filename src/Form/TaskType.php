<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Task;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
            ])
            ->add('title', TextType::class)
            ->add('status', ChoiceType::class, [
                'choices' =>[
                    'Pending' => Task::STATUS_PENDING,
                    'In Progress' => Task::STATUS_IN_PROGRESS,
                    'Done' => Task::STATUS_DONE,
                ]
            ])
            ->add('priority', ChoiceType::class, [
                'choices' =>[
                    'Low' => Task::PRIORITY_LOW,
                    'Mid' => Task::PRIORITY_MEDIUM,
                    'High' => Task::PRIORITY_HIGH,
                ]
            ])
            ->add('deadline', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker form-control'
                ],
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
