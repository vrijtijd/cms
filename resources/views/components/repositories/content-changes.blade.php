@props(['changes', 'repository'])

@foreach ($changes as $changeType => $contentChanges)
    <div class="mt-3">
        <x-repositories.content-change-group :repository="$repository" :type="$changeType" :changes="$contentChanges"/>
    </div>
@endforeach
