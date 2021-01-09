<x-form-panel
    :method="$method"
    :action="$action"
    :attributes="$attributes"
>
    <div class="col-span-6 lg:col-span-4">
        <x-jet-label for="name" value="Name" />
        <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$repository->name" />
        <x-jet-input-error for="name" class="mt-2" />
    </div>
    <div class="col-span-6 lg:col-span-4">
        <x-jet-label for="url" value="Git URL" />
        <x-jet-input id="url" name="url" type="text" class="mt-1 block w-full" :value="$repository->url" />
        <x-jet-input-error for="url" class="mt-2" />
    </div>
    <div class="col-span-6 lg:col-span-4">
        <x-jet-label for="website" value="Website URL" />
        <x-jet-input id="website" name="website" type="text" class="mt-1 block w-full" :value="$repository->website"  />
        <x-jet-input-error for="website" class="mt-2" />
    </div>
    <div class="col-span-6 lg:col-span-4">
        <x-jet-label for="team" value="Team" />
        <select id="team" name="team" class="form-input rounded-md shadow-sm mt-1 block w-full">
            @foreach ($teams as $team)
                <option value="{{ $team->id }}" {{ $isEdit && $repository->team->id === $team->id ? 'selected' : ''}}>
                    {{ $team->name }}
                </option>
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
