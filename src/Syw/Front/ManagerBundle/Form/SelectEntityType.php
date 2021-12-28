<?php

namespace Syw\Front\ManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SelectEntityType
 *
 * @category FormType
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class SelectEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('city_id', 'entity', array(
            'required'      => false,
            'class'         => 'SywFrontMainBundle:Cities',
            'property'      => 'id',
            'property_path' => '[id]',
            'multiple'      => true,
            'expanded'      => true
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => null,
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return 'selectentity';
    }
}
