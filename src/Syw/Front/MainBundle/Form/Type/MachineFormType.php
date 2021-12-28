<?php

namespace Syw\Front\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Syw\Front\MainBundle\Entity\Machines;

/**
 * Class MachineFormType
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class MachineFormType extends AbstractType
{
    private $user;
    private $machine;

    public function __construct($machine)
    {
        $this->machine = $machine;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('updateKey', 'text', array('label' => 'Update Key', 'read_only' => true))
            ->add('hostname', 'text', array('label' => 'Hostname', 'required' => false))
            ->add('country', 'shtumi_ajax_autocomplete', array(
                'entity_alias'=>'countries',
                'required' => false,
                'label' => 'Country'
            ))
            ->add('online', 'checkbox', array('label' => 'Online', 'required' => false))
            ->add('class', 'shtumi_ajax_autocomplete', array(
                'entity_alias'=>'classes',
                'required' => false,
                'label' => 'Class'
            ))
            ->add('distribution', 'shtumi_ajax_autocomplete', array(
                'entity_alias'=>'distributions',
                'required' => false,
                'label' => 'Distribution'
            ))
            ->add('distversion', 'text', array('label' => 'Distribution Version', 'required' => false))
            ->add('architecture', 'shtumi_ajax_autocomplete', array(
                'entity_alias'=>'architectures',
                'required' => false,
                'label' => 'Architecture'
            ))
            ->add('kernel', 'shtumi_ajax_autocomplete', array(
                'entity_alias'=>'kernels',
                'required' => false,
                'label' => 'Kernel'
            ))
            ->add('cpu', 'shtumi_ajax_autocomplete', array(
                'entity_alias'=>'cpus',
                'required' => false,
                'label' => 'Processor'
            ))
            ->add('cores', 'text', array('label' => 'CPU Cores', 'required' => false))
            ->add('flags', 'text', array('label' => 'CPU Flags', 'required' => false))
            ->add('diskspace', 'text', array('label' => 'Diskspace complete', 'required' => false))
            ->add('diskspaceFree', 'text', array('label' => 'Diskspace Free', 'required' => false))
            ->add('memory', 'text', array('label' => 'Memory complete', 'required' => false))
            ->add('memoryFree', 'text', array('label' => 'Memory Free', 'required' => false))
            ->add('swap', 'text', array('label' => 'Swap complete', 'required' => false))
            ->add('swapFree', 'text', array('label' => 'Swap Free', 'required' => false))
            ->add('mailer', 'text', array('label' => 'Mailer software', 'required' => false))
            ->add('network', 'text', array('label' => 'Network', 'required' => false))
            ->add('accounts', 'text', array('label' => 'Number of Accounts', 'required' => false))
            ->add('uptime', 'text', array('label' => 'Current Uptime', 'required' => false))
            ->add('loadavg', 'text', array('label' => 'Load average', 'required' => false))

            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'machine';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Syw\Front\MainBundle\Entity\Machines'
        ));
    }
}
