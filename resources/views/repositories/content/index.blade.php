<x-repo-layout :repository="$repository">
    <h1 class="text-3xl font-bold">
        {{ $archetype }}
    </h1>

    <table class="min-w-full divide-y divide-gray-200 mt-4">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($contentFiles as $contentFile)
                <tr class="whitespace-nowrap text-sm text-gray-900">
                    <td class="px-6 py-4">
                        {{ $contentFile->getName() }}
                    </td>
                    <td class="px-6 py-4 flex justify-end space-x-4">
                        <a
                            href="{{ route('repositories.content.edit', [$repository->id, $archetype, $contentFile->getSlug()]) }}"
                            class="text-blue-600 hover:text-blue-800"
                        >
                            Edit
                        </a>
                        <x-form-button
                            :action="route('repositories.content.destroy', [$repository->id, $archetype, $contentFile->getSlug()])"
                            method="DELETE"
                            class="text-red-600 hover:text-red-800 font-bold"
                            x-data=""
                            @click="return confirm('Are you sure?')"
                        >
                            Delete
                        </x-form-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-repo-layout>
