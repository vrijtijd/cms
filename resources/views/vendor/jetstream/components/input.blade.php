@props(['disabled' => false, 'name' => '', 'type' => 'text'])

<x-input :name="$name" :type="$type" :attributes="$attributes->merge([
    'class' => 'form-input rounded-md shadow-sm',
    'disabled' => $disabled,
])" />

