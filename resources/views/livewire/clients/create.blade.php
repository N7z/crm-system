<?php

use App\Models\Client;
use Livewire\Volt\Component;

new class extends Component {
    public $name, $email, $phone, $cpf, $state, $city, $address;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'cpf' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        Client::create($validated);

        Toaster::success('Cliente cadastrado com sucesso!');
        return redirect()->route('clients.index');
    }

}; ?>

<div x-data x-init="IMask($refs.phone, { mask: '(00) 00000-0000' }); IMask($refs.cpf, { mask: '000.000.000-00' }); ">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Cadastrar novo Cliente') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Preencha os dados abaixo') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <form wire:submit.prevent="save" class="space-y-4">
        <flux:input label="Nome" wire:model="name" required />
        <flux:input label="E-mail" type="email" wire:model="email" required />
        <flux:input label="Telefone" x-ref="phone" wire:model="phone" placeholder="(00) 00000-0000" required />
        <flux:input label="CPF" x-ref="cpf" wire:model="cpf" placeholder="000.000.000-00" required />
        <flux:input label="Estado" wire:model="state" />
        <flux:input label="Cidade" wire:model="city" />
        <flux:input label="Endereço" wire:model="address" />
        <flux:button type="submit" variant="primary">{{ __('Salvar') }}</flux:button>
    </form>
</div>
