@if ($type === 'DateTime')
    <x-repositories.content.date-input :label="$name" name="frontmatter[{{ $name }}]" :date="$value"/>
@elseif ($type === 'boolean')
    <x-repositories.content.boolean-input :label="$name" name="frontmatter[{{ $name }}]" :value="$value"/>
@else
    <x-repositories.content.text-input :label="$name" name="frontmatter[{{ $name }}]" :value="$value"/>
@endif