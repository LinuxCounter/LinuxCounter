<?php

namespace Syw\Front\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Class CityFormType
 *
 * @category FormType
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class CityFormType extends AbstractType
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
        $collectionConstraint = new Collection(array(
            'isoCountryCode' => array(
                new NotBlank(array('message' => 'The ISO country code should not be blank. Please enter the two country code letters in upper case.')),
                new Length(array('min' => 2, 'max' => 2))
            ),
            'region' => array(
                new NotBlank(array('message' => 'The region should not be blank.')),
                new Length(array('min' => 2))
            ),
            'name' => array(
                new NotBlank(array('message' => 'Subject should not be blank.')),
                new Length(array('min' => 3))
            ),
            'latitude' => array(
                new NotBlank(array('message' => 'Latitude should not be blank.')),
                new Length(array('min' => 2))
            ),
            'longitude' => array(
                new NotBlank(array('message' => 'Longitude should not be blank.')),
                new Length(array('min' => 2))
            ),
            'population' => array(
                new NotBlank(array('message' => 'Population should not be blank.')),
                new Length(array('min' => 1))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'addcity';
    }
}
