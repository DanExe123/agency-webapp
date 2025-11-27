<div class="items-start justify-center">
    @include('partials.settings-heading')

    <div class="flex items-start justify-center max-md:flex-col">
        <!-- Sidebar -->
        <div class="md:me-10 w-full pb-4 md:w-[220px]">
            <flux:navlist>
                <flux:navlist.item :href="route('settings.profile')" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
                <flux:navlist.item :href="route('settings.password')" wire:navigate>{{ __('Password') }}</flux:navlist.item>
                <flux:navlist.item :href="route('settings.appearance')" wire:navigate>{{ __('Appearance') }}</flux:navlist.item>
            </flux:navlist>
        </div>

        <flux:separator class="md:hidden" />

        <!-- Main Content -->
        <div class="flex-1 self-stretch max-md:pt-6 w-full max-w-4xl">
            <flux:heading>{{ $heading ?? '' }}</flux:heading>
            <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

            <div class="mt-5 w-full">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
