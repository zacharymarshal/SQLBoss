<?php

App::uses('FormHelper', 'View/Helper');

class ExtraFormHelper extends FormHelper
{
    protected $input_defaults = array(
        'div' => array(
            'class' => 'form-group'
        ),
        'class'     => 'form-control',
    );

    public function create($model = null, $options = array())
    {
        if ( ! isset($options['inputDefaults'])) {
            $options['inputDefaults'] = $this->input_defaults;
        }
        if ( ! isset($options['class'])) {
            $options['class'] = 'form';
        }

        return parent::create($model, $options);
    }

    public function submit($caption = null, $options = array())
    {
        $defaultOptions = array(
            'class'  => 'btn btn-primary',
            'div'    => 'form-group',
        );
        $options = array_merge($defaultOptions, $options);

        return parent::submit($caption, $options);
    }
}
