<?php

namespace Syw\Front\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Syw\Front\MainBundle\Entity\UserProfile;

/**
 * Class UserProfileFormType
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class UserProfileFormType extends AbstractType
{
    private $user;
    private $userProfile;

    public function __construct($userProfile)
    {
        $this->userProfile = $userProfile;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $city = $this->userProfile->getCity();

        $builder
            ->add('city', 'shtumi_ajax_autocomplete', array(
                'entity_alias'=>'cities',
                'required' => false,
                'label' => 'City'
            ))

            ->add('country', 'shtumi_ajax_autocomplete', array(
                'entity_alias'=>'countries',
                'required' => false,
                'label' => 'Country'
            ))

            ->add('firstname', 'text', array('label' => 'Firstname', 'required' => false))
            ->add('lastname', 'text', array('label' => 'Lastname', 'required' => false))

            ->add('birthday', 'birthday', array('label' => 'Birthday',  'required' => false, 'input'  => 'string', 'widget' => 'choice', 'years' => range(1900, date('Y'))))
            ->add('birthplace', 'text', array('label' => 'Birthplace', 'required' => false))

            ->add('sincewhen', 'date', array('label' => 'Since when using Linux', 'required' => false, 'input'  => 'string', 'widget' => 'choice', 'years' => range(1991, date('Y'))))
            ->add('homepage', 'text', array('label' => 'Homepage', 'required' => false))
            ->add('icq', 'text', array('label' => 'ICQ', 'required' => false))
            ->add('skype', 'text', array('label' => 'Skype', 'required' => false))
            ->add('jabber', 'text', array('label' => 'Jabber', 'required' => false))
            ->add('irc', 'text', array('label' => 'IRC', 'required' => false))
            ->add('gpg', 'text', array('label' => 'PGP/GPG', 'required' => false))
            ->add('facebook', 'text', array('label' => 'Facebook page', 'required' => false))
            ->add('google', 'text', array('label' => 'Google+ Page', 'required' => false))
            ->add('twitter', 'text', array('label' => 'Twitter', 'required' => false))
            ->add('identica', 'text', array('label' => 'Identi.ca', 'required' => false))
            ->add('github', 'text', array('label' => 'Github', 'required' => false))
            ->add('linkedin', 'text', array('label' => 'Linkedin', 'required' => false))

            ->add('interests', 'textarea', array('label' => 'Interests', 'required' => false))
            ->add('hobbies', 'textarea', array('label' => 'Hobbies', 'required' => false))

            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'userprofile';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Syw\Front\MainBundle\Entity\UserProfile',
        ));
    }
}
