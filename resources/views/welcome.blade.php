<x-app-layout>
    <div class="mx-6">
        <div class="text-6xl font-bold text-center mt-12">
            Hey, there!
        </div>

        <p class="text-center mt-12 mx-auto max-w-prose">
            Welcome to {{ config('app.name') }}. Here, you can add, edit, and delete any content on the website(s) that we've built for you. If you run into any issues, please <a href="mailto:{{ env('SUPPORT_EMAIL') }}" class="border-b-2 border-vt-darkGray-900">let us know</a>.
        </p>

        <x-illustration-content-team class="w-full md:w-3/4 max-w-prose mx-auto my-12 px-8" />
    </div>
</x-app-layout>
