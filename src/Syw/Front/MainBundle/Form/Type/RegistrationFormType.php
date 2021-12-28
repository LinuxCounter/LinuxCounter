<?php

namespace Syw\Front\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True;

/**
 * Class RegistrationFormType
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'locale',
                'hidden',
                array(
                    'empty_data' => 'en',
                    'data' => 'en'
                )
            );

        $builder
            ->add(
                'newsletter',
                'checkbox',
                array(
                    'mapped' => false,
                    'required' => false,
                    'attr'   => array('checked'   => 'checked'),
                    'label' => 'Newsletter subscription'
                )
            );

        /*
        $builder->add('recaptcha', 'ewz_recaptcha', array(
            'attr' => array(
                'options' => array(
                    'theme' => 'light',
                    'type'  => 'image'
                )
            ),
            'mapped'      => false,
            'constraints' => array(
                new True()
            )
        ));
        */
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'syw_user_registration';
    }
}
