<x-app>
    <x-slot name="title">
        login
    </x-slot>
    <x-slot name="style">
        <style>
            .todo-striping::before, .todo-striping::after {
                color: #e4e6e9;
                content: "————";
                font-size: 24px;
                margin: 10px;
            }
        </style>
    </x-slot>
    <x-slot name="script">
    </x-slot>
    <x-slot name="main">
       <livewire:auth.login :linkedAccount="$linkedAccount ?? false" />
    </x-slot>
</x-app>
