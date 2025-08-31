<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'block w-auto text-center px-6 py-2 rounded-lg duration-200 font-semibold',
    ]) }}>
    {{ $slot }}
</button>
