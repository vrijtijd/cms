<div class="overflow-x-auto">
    <div class="py-2 align-middle inline-block min-w-full">
        <div class="shadow overflow-hidden border-b border-vt-lightGray-200 rounded-lg">
            <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-vt-lightGray-200']) }}>
                <thead class="bg-vt-lightGray-100">
                    <tr>
                        {{ $headings }}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-vt-lightGray-400">
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>
