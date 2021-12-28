<?php

namespace Syw\Front\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Asm\TranslationLoaderBundle\Entity\Translation;

/**
 * Class TranslationFormType
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class TranslationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('transKey', 'textarea', array('label' => 'Database Key', 'required' => true, 'disabled' => false, 'attr' => array('class' => 'transKey')))
            ->add('transLocale', 'hidden', array('label' => 'Locale', 'required' => true, 'disabled' => false))
            ->add('messageDomain', 'hidden', array('label' => 'Domain', 'required' => true, 'disabled' => false))
            ->add('translation', 'textarea', array('label' => 'Your Translation', 'required' => true, 'disabled' => false));
    }

    public function getName()
    {
        return 'translation';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Asm\TranslationLoaderBundle\Entity\Translation',
        ));
    }
}
