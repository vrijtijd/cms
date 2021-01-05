@props(['icon' => 'check-circle'])

<div {{ $attributes->merge([
    'class' => 'rounded-md bg-vt-blue-200 p-4 text-vt-darkGray-400',
]) }}>
    <div class="flex">
        <div class="flex-shrink-0">
            <x-icon :name="$icon" class="h-5 w-5"/>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium">
                {{ $slot }}
            </p>
        </div>
    </div>
</div>
