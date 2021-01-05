@props(['repositories'])

<div class="overflow-x-auto">
    <div class="py-2 align-middle inline-block min-w-full">
        <div class="shadow overflow-hidden border-b border-vt-lightGray-200 rounded-lg">
            <table class="min-w-full divide-y divide-vt-lightGray-200">
                <thead class="bg-vt-lightGray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-vt-darkGray-400 uppercase tracking-wider">
                            Repository
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-vt-darkGray-400 uppercase tracking-wider">
                            Git URL
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-vt-darkGray-400 uppercase tracking-wider">
                            Team
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-vt-lightGray-400">
                    @foreach($repositories as $repo)
                        <x-repositories.table-row :repository="$repo"/>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
