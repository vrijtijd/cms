@if ($type === 'DateTime')
    <x-repositories.content.date-input :label="$name" name="frontmatter[{{ $name }}]" :date="$value"/>
@else
    <x-repositories.content.text-input :label="$name" name="frontmatter[{{ $name }}]" :value="$value"/>
@endif
