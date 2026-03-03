{{ html()->form('DELETE', $action)
    ->class('inline')
    ->open() }}

    <button type="submit"
        onclick="return confirm('{{ $message }}')"
        {{ $attributes->merge([
            'class' => 'text-red-600 hover:text-red-800 bg-transparent border-0 p-0 cursor-pointer'
        ]) }}>
        {{ $slot ?: 'Delete' }}
    </button>

{{ html()->form()->close() }}