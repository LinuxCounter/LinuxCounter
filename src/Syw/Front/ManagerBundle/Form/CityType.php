<?php

namespace Syw\Front\ManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CityType
 *
 * @category FormType
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isoCountryCode', 'text', array(
                'attr' => array(
                    'placeholder' => 'The ISO country code (e.g. US or DE)',
                    'pattern'     => '.{2}' // exact 2 chars
                )
            ))
            ->add('region', 'text', array(
                'attr' => array(
                    'placeholder' => 'The state or region (e.g. Texas, Utah or Baden-Württemberg)'
                )
            ))
            ->add('name', 'text', array(
                'attr' => array(
                    'placeholder' => 'The full name of the city',
                    'pattern'     => '.{2,}'  // minlength
                )
            ))
            ->add('latitude', 'text', array(
                'attr' => array(
                    'placeholder' => 'The Latitude of this city (e.g. 47.818373)',
                    'pattern'     => '.{2,}'  // minlength
                )
            ))
            ->add('longitude', 'text', array(
                'attr' => array(
                    'placeholder' => 'The Longitude of this city (e.g. 9.056706)',
                    'pattern'     => '.{2,}'  // minlength
                )
            ))
            ->add('population', 'integer', array(
                'attr' => array(
                    'placeholder' => 'How many peoples are living in this city?'
                )
            ))
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Syw\Front\MainBundle\Entity\Cities',
        ));
    }

    public function getName()
    {
        return 'city';
    }
}
