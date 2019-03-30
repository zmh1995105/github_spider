<?php
namespace App\Html\Form;

use Illuminate\Contracts\Support\Arrayable;
use Lavender\Contracts\Entity as EntityContract;

class Select
{
    public function dropdown($selected, $attributes, $resource)
    {
        $options = $this->buildOptions($selected, $resource);

        return '<select'.attr($attributes).'>'.implode(PHP_EOL, $options).'</select>';
    }

    protected function buildOptions($selected, $resource)
    {
        $html = [];

        foreach($resource as $value => $option){

            $html[] = $this->getSelectOption($option, $value, $selected);

        }

        return $html;
    }

    /**
     * Get the select option for the given value.
     *
     * @param  string  $option
     * @param  string  $value
     * @param  string  $selected
     * @return string
     */
    protected function getSelectOption($option, $value, $selected)
    {
        if(is_array($option)){

            return $this->optionGroup($option, $value, $selected);

        }

        return $this->option($option, $value, $selected);
    }

    /**
     * Create an option group form element.
     *
     * @param  array   $list
     * @param  string  $label
     * @param  string  $selected
     * @return string
     */
    protected function optionGroup($options, $label, $selected)
    {
        $html = [];

        foreach($options as $value => $option){

            $html[] = $this->option($option, $value, $selected);

        }

        return '<optgroup label="'.e($label).'">'.implode('', $html).'</optgroup>';
    }

    /**
     * Create a select element option.
     *
     * @param  string  $display
     * @param  string  $value
     * @param  string  $selected
     * @return string
     */
    protected function option($display, $value, $selected)
    {
        $selected = $this->getSelectedValue($value, $selected);

        $options = ['value' => e($value), 'selected' => $selected];

        return '<option'.attr($options).'>'.e($display).'</option>';
    }

    /**
     * Determine if the value is selected.
     *
     * @param  string  $value
     * @param  string  $selected
     * @return string
     */
    protected function getSelectedValue($value, $selected)
    {
        if (is_array($selected))
        {
            return in_array($value, $selected) ? 'selected' : null;
        }

        return ((string) $value == (string) $selected) ? 'selected' : null;
    }

}