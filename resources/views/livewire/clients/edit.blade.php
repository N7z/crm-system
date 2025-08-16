<?php

use App\Models\Client;
use Livewire\Volt\Component;

new class extends Component {
    public $client;

    public $name, $email, $phone, $cpf, $state, $city, $address;

    public function mount(Client $client): void
    {
        $this->client = $client;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->cpf = $client->cpf;
        $this->state = $client->state;
        $this->city = $client->city;
        $this->address = $client->address;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'cpf' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $this->client->update($validated);

        Toaster::success('Cliente editado com sucesso!');
        return back();
    }

}; ?>

<div x-data x-init="IMask($refs.phone, { mask: '(00) 00000-0000' }); IMask($refs.cpf, { mask: '000.000.000-00' }); ">
    <button @click="Toaster.success('Form submitted!')">
        Submit
    </button>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Editar Cliente') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Preencha os dados abaixo') }}</flux:subheading>

        @if(session('success'))
            <div class="mb-3 bg-green-300 dark:bg-green-700 border border-green-400 dark:border-green-900 dark:text-white px-4 py-2 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <flux:separator variant="subtle" />
    </div>

    <form wire:submit.prevent="save" class="space-y-4">
        <flux:input label="Nome" wire:model="name" required />
        <flux:input label="E-mail" type="email" wire:model="email" />
        <flux:input label="Telefone" x-ref="phone" wire:model="phone" placeholder="(00) 00000-0000" />
        <flux:input label="CPF" x-ref="cpf" wire:model="cpf" placeholder="000.000.000-00" />
        <flux:input label="Estado" wire:model="state" />
        <flux:input label="Cidade" wire:model="city" />
        <flux:input label="Endereço" wire:model="address" />
        <flux:button type="submit" variant="primary">{{ __('Salvar') }}</flux:button>
    </form>
</div>
