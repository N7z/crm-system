<?php

use App\Models\Category;
use Livewire\Volt\Component;

new class extends Component {
    public $category;

    public $name, $status;

    public function mount(Category $category): void
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->status = $category->status;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive'
        ]);

        $this->category->update($validated);

        Toaster::success('Categoria editada com sucesso!');
        return back();
    }

}; ?>

<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Editar Categoria') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Preencha os dados abaixo') }}</flux:subheading>
        <flux:separator variant="subtle"/>
    </div>

    <form wire:submit.prevent="save" class="space-y-4">
        <flux:input label="Nome" wire:model="name" required/>
        <flux:select label="Situação" wire:model="status" required >
            <flux:select.option value="">-- Selecione --</flux:select.option>
            <flux:select.option value="active">Ativada</flux:select.option>
            <flux:select.option value="inactive">Desativada</flux:select.option>
        </flux:select>
        <flux:button type="submit" variant="primary">{{ __('Salvar') }}</flux:button>
    </form>
</div>
