@props(['repository'])

<tr class="whitespace-nowrap text-sm text-gray-900">
    <td class="px-6 py-4">
        {{ $repository->name }}
    </td>
    <td class="px-6 py-4">
        {{ $repository->url }}
    </td>
    <td class="px-6 py-4">
        Team name
    </td>
    <td class="px-6 py-4">
        Website
    </td>
    <td class="px-6 py-4">
        <x-form-button
            :action="route('admin.repositories.destroy', $repository->id)"
            method="DELETE"
            class="text-red-600 hover:text-red-800 font-bold"
            x-data=""
            @click="return confirm('Are you sure?')"
        >
            Delete
        </x-form-button>
    </td>
</tr>
