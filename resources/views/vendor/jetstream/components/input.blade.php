@props(['disabled' => false, 'name' => '', 'type' => 'text', 'id' => ''])

<x-input :name="$name" :type="$type" :id="$id" :attributes="$attributes->merge([
    'class' => 'form-input rounded-md shadow-sm',
    'disabled' => $disabled,
])" />

