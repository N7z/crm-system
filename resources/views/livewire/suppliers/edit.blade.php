<?php

use App\Models\Supplier;
use Livewire\Volt\Component;

new class extends Component {
    public $supplier;

    public $name, $email, $phone, $cnpj, $state, $city, $address;

    public function mount(Supplier $supplier): void
    {
        $this->supplier = $supplier;
        $this->name = $supplier->name;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;
        $this->cnpj = $supplier->cnpj;
        $this->state = $supplier->state;
        $this->city = $supplier->city;
        $this->address = $supplier->address;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'cnpj' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $this->supplier->update($validated);

        Toaster::success('Fornecedor editado com sucesso!');
        return back();
    }

}; ?>

<div x-data x-init="IMask($refs.phone, { mask: '(00) 00000-0000' }); IMask($refs.cnpj, { mask: '00.000.000/0000-00' }); ">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Editar Fornecedor') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Preencha os dados abaixo') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <form wire:submit.prevent="save" class="space-y-4">
        <flux:input label="Nome" wire:model="name" required />
        <flux:input label="E-mail" type="email" wire:model="email" />
        <flux:input label="Telefone" x-ref="phone" wire:model="phone" placeholder="(00) 00000-0000" />
        <flux:input label="CNPJ" x-ref="cnpj" wire:model="cnpj" placeholder="00.000.000/0000-00" />
        <flux:input label="Estado" wire:model="state" />
        <flux:input label="Cidade" wire:model="city" />
        <flux:input label="Endereço" wire:model="address" />
        <flux:button type="submit" variant="primary">{{ __('Salvar') }}</flux:button>
    </form>
</div>
