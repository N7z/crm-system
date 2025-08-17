<?php

use App\Models\Category;
use Livewire\Volt\Component;

new class extends Component {
    public $name, $status;

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        Category::create($validated);

        Toaster::success('Categoria cadastrada com sucesso!');
        return redirect()->route('categories.index');
    }

}; ?>

<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Cadastrar nova Categoria') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Preencha os dados abaixo') }}</flux:subheading>
        <flux:separator variant="subtle"/>
    </div>

    <form wire:submit.prevent="save" class="space-y-4">
        <flux:input label="Nome" wire:model="name" required />
        <flux:select label="Situação" wire:model="status" required >
            <flux:select.option value="">-- Selecione --</flux:select.option>
            <flux:select.option value="active">Ativada</flux:select.option>
            <flux:select.option value="inactive">Desativada</flux:select.option>
        </flux:select>
        <flux:button type="submit" variant="primary">{{ __('Salvar') }}</flux:button>
    </form>
</div>
