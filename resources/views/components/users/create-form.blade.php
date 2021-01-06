@props(['teams'])

<x-form-panel
    method="POST"
    action="{{ route('admin.users.store') }}"
    :attributes="$attributes"
>
    <div class="col-span-6 lg:col-span-4">
        <x-jet-label for="name" value="Name" />
        <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full" />
        <x-jet-input-error for="name" class="mt-2" />
    </div>
    <div class="col-span-6 lg:col-span-4">
        <x-jet-label for="email" value="Email" />
        <x-jet-input id="email" name="email" type="email" class="mt-1 block w-full" />
        <x-jet-input-error for="email" class="mt-2" />
    </div>
    <div class="col-span-6 lg:col-span-4">
        <x-jet-label for="team" value="Team" />
        <select id="team" name="team" class="form-input rounded-md shadow-sm mt-1 block w-full">
            <option value="">Create new</option>

            @foreach ($teams as $team)
                <option value="{{ $team->id }}">{{ $team->name }}</option>
            @endforeach
        </select>
        <x-jet-input-error for="team" class="mt-2" />
    </div>

    <x-slot name="actions">
        <x-jet-button>
            Save
        </x-jet-button>
    </x-slot>
</x-form-panel>
