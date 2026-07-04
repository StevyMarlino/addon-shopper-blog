<x-shopper::container class="py-5">
    <x-shopper::heading :title="__('Blog Posts')" />

    <div class="mt-10">
        {{ $this->table }}
    </div>
</x-shopper::container>
