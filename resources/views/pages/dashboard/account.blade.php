<x-dashboard-layout>
    <x-slot name="title">
        个人中心
    </x-slot>
    <x-slot name="tab">
        个人中心
    </x-slot>
    <x-slot name="content">
        <livewire:dashboard.account/>
    </x-slot>
    <x-slot name="layer">
        <div class="hidden" x-ref="layer">
            <livewire:dashboard.layer.account/>
        </div>
    </x-slot>
</x-dashboard-layout>