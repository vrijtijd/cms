@if ($type === 'DateTime')
    <x-repositories.content.date-input :label="$name" name="frontmatter[{{ $name }}]" :date="$value"/>
@elseif ($type === 'boolean')
    <x-repositories.content.boolean-input name="frontmatter[{{ $name }}]" :value="$value"/>
@else
    <x-jet-input
        class="mt-1 block w-full"
        type="text"
        :id="$name"
        name="frontmatter[{{ $name }}]"
        :value="$value"/>
@endif
