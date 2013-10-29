<?php

namespace CoralScrum\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserProjectType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $projectId = $options['projectId'];

        if(is_null($projectId))
            throw new \LogicException('ProjectId option is required.');

        $builder
            ->add('user', 'entity', array(
                'class' => 'CoralScrumUserBundle:User',
                'label' => 'User',
                'required' => true,
                'query_builder' => function(\CoralScrum\UserBundle\Entity\UserRepository  $er) use ($projectId) {
                    return $er->createQueryBuilder('u')
                              ->leftJoin('u.userproject', 'us_p')
                              ->where('us_p.project IS NULL')
                              ->orWhere('us_p.project != :projectId')
                              ->setParameter('projectId', $projectId)
                              ->orderBy('u.username', 'ASC');
                },
            ))
            ->add('accountType', 'choice', array(
                'choices'  => array(
                    'Developper'    => 'Developper',
                    'Scrum Master'  => 'Scrum Master',
                    'Project Owner' => 'Project Owner'),
                'required' => true
            ))
            //->add('isAccept')
            //->add('project')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoralScrum\MainBundle\Entity\UserProject',
            'projectId'  => null,
        ));

        $resolver->setRequired(array(
            'projectId',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'coralscrum_mainbundle_userproject';
    }
}
