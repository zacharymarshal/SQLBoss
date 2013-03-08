<?php

App::uses('FormHelper', 'View/Helper');

class ExtraFormHelper extends FormHelper
{
    protected $input_defaults = array(
        'format'  => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div'     => array('class' => 'control-group'),
        'label'   => array('class' => 'control-label'),
        // 'between' => '<div class="controls">',
        // 'after'   => '</div>',
        'error'   => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
    );

    public function create($model = null, $options = array())
    {
        if ( ! isset($options['inputDefaults'])) {
            $options['inputDefaults'] = $this->input_defaults;
        }
        if ( ! isset($options['class'])) {
            $options['class'] = 'form-vertical';
        }
        return parent::create($model, $options);
    }

    public function submit($caption = null, $options = array())
    {
        if ( ! isset($options['class'])) {
            $options['class'] = 'btn';
        }
        return parent::submit($caption, $options);
    }
}
