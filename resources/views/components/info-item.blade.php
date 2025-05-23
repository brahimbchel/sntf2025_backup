@props([
    'label',
    'value' => null,
    'class' => '',
])

<div class="flex justify-between items-center py-1">
    <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">
        {{ $label }}
    </dt>
    <dd class="text-sm font-semibold text-gray-900 dark:text-white {{ $class }}">
        {{ $value ?? $slot }}
    </dd>
</div>
