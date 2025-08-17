<?php

use App\Models\Supplier;
use Livewire\Volt\Component;

new class extends Component {
    public $name, $email, $phone, $cnpj, $state, $city, $address;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'cnpj' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        Supplier::create($validated);

        Toaster::success('Fornecedor cadastrado com sucesso!');
        return redirect()->route('suppliers.index');
    }

}; ?>

<div x-data
     x-init="IMask($refs.phone, { mask: '(00) 00000-0000' }); IMask($refs.cnpj, { mask: '00.000.000/0000-00' }); ">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Cadastrar novo Fornecedor') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Preencha os dados abaixo') }}</flux:subheading>
        <flux:separator variant="subtle"/>
    </div>

    <form wire:submit.prevent="save" class="space-y-4">
        <flux:input label="Nome" wire:model="name" required />
        <flux:input label="E-mail" type="email" wire:model="email" required />
        <flux:input label="Telefone" x-ref="phone" wire:model="phone" placeholder="(00) 00000-0000" required />
        <flux:input label="CNPJ" x-ref="cnpj" wire:model="cnpj" placeholder="00.000.000/0000-00" required />
        <flux:input label="Estado" wire:model="state" />
        <flux:input label="Cidade" wire:model="city" />
        <flux:input label="Endereço" wire:model="address" />
        <flux:button type="submit" variant="primary">{{ __('Salvar') }}</flux:button>
    </form>
</div>
