<x-admin-layout>
    <h1 class="text-3xl font-bold">Repositories</h1>

    <div class="bg-white rounded shadow p-4 my-4">
        <x-repositories.create-form/>
    </div>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <x-repositories.table :repositories="$repositories"/>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
