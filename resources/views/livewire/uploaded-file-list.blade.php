<div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-4">
    @foreach ($filenames as $filename)
        <livewire:uploaded-file :key="$filename" :repository="$repository" :filename="$filename"/>
    @endforeach
</div>
