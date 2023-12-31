@props([
    'name' => 'modal',
    'maxWidth' => '2xl',
    'title' => 'Header',
    'method' => null,
])

@php
    $maxWidth =
        [
            'sm' => 'sm:max-w-sm',
            'md' => 'sm:max-w-md',
            'lg' => 'sm:max-w-lg',
            'xl' => 'sm:max-w-xl',
            '2xl' => 'sm:max-w-2xl',
        ][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<div class="z-20 fixed inset-0" x-data="{ visible: false, name: '{{ $name }}' }"
    x-on:open-modal.window="($event.detail.id && name === $event.detail.name) ? $wire.load($event.detail.id) : visible = (name === $event.detail.name)"
    x-on:close-modal.window="(name === $event.detail.name) && (visible = false && $wire.clear())" x-transition
    x-show="visible" x-cloak>
    <div wire:loading.class="pointer-events-none" class="bg-gray-100 dark:bg-gray-800 opacity-80 inset-0 absolute"
        x-on:click="$dispatch('close-modal', {name: name})"></div>
    <div
        class="{{ $maxWidth }} bg-white dark:bg-gray-700 mx-auto mt-4 z-30 dark:text-white p-4 rounded text-black relative">
        @if (isset($method))
            <form wire:submit="{{ $method }}">
        @endif
        <div class="p-4 flex justify-between">
            {{ __($title) }}
            <button x-on:click="visible = false">
                &cross;
            </button>
        </div>
        <div class="p-4">
            <div>
                {{ $slot }}
            </div>
        </div>
        <div class="p-4 flex justify-end gap-1">
            <x-element.button.secondary wire:loading.attr="disabled" type="button"
                x-on:click="$dispatch('close-modal', {name: name})">
                {{ __('Close') }}
            </x-element.button.secondary>
            {{ $button ?? '' }}
        </div>
        @if (isset($method))
            </form>
        @endif
    </div>
</div>
