<?php
namespace KTU\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CronJobType extends AbstractType
{
    protected $jobs;

    public function __construct($jobs)
    {
        $this->jobs = $jobs;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choice = [];

        foreach($this->jobs as $job)
        {
            $choice[$job->getId()] = $job->getAction();
        }

        $builder->add('emails', 'collection', [
                'type'   => 'email',
                'options'  => [
                    'required'  => false,
                    'choices' => $choice,
                ],
            ]);
    }

    public function getName()
    {
        return 'cron_job';
    }
} 