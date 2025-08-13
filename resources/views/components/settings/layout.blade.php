<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav class="flex flex-col space-y-2">
            <a href="{{ route('settings.profile') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">{{ __('Profile') }}</a>
            <a href="{{ route('settings.password') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">{{ __('Password') }}</a>
        </nav>
    </div>

    <hr class="md:hidden">

    <div class="flex-1 self-stretch max-md:pt-6">
        <h2 class="text-lg font-medium text-gray-900">{{ $heading ?? '' }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ $subheading ?? '' }}</p>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
