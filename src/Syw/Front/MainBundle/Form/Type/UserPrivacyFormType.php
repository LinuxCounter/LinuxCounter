<?php

namespace Syw\Front\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Syw\Front\MainBundle\Entity\Privacy;

/**
 * Class UserProfileFormType
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class UserPrivacyFormType extends AbstractType
{
    private $user;
    private $userPrivacy;

    public function __construct($userPrivacy)
    {
        $this->userPrivacy = $userPrivacy;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secretProfile', 'checkbox', array('label' => 'Hide my whole profile', 'required' => false))
            ->add('secretCounterData', 'checkbox', array('label' => 'Hide counter related user information', 'required' => false))
            ->add('secretMachines', 'checkbox', array('label' => 'Hide all my machines', 'required' => false))
            ->add('secretContactInfo', 'checkbox', array('label' => 'Hide all of my contact information', 'required' => false))
            ->add('secretSocialInfo', 'checkbox', array('label' => 'Hide all of my social networks', 'required' => false))
            ->add('showRealName', 'checkbox', array('label' => 'Show my real name', 'required' => false))
            ->add('showEmail', 'checkbox', array('label' => 'Show my email address', 'required' => false))
            ->add('showLocation', 'checkbox', array('label' => 'Show my location information', 'required' => false))
            ->add('showHostnames', 'checkbox', array('label' => 'Show the hostnames of my machines', 'required' => false))
            ->add('showKernel', 'checkbox', array('label' => 'Show the kernels of my machines', 'required' => false))
            ->add('showDistribution', 'checkbox', array('label' => 'Show the distributions of my machines', 'required' => false))
            ->add('showVersions', 'checkbox', array('label' => 'Show all version information of my machines', 'required' => false))

            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'userprivacy';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Syw\Front\MainBundle\Entity\Privacy',
        ));
    }
}
