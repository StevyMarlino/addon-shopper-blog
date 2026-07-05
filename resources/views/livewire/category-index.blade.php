<x-shopper::container class="py-5">
    <x-shopper::heading :title="__('Blog Categories')">
        <x-slot name="action">
            <x-filament::button
                    wire:click="$dispatch('openPanel', { component: 'shopper-slide-overs.category-form' })"
                    type="button"
            >
                {{ __('Add category') }}
            </x-filament::button>
        </x-slot>
    </x-shopper::heading>

    <div class="mt-10">
        {{ $this->table }}
    </div>
</x-shopper::container>
