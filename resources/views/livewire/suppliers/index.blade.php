<?php

use App\Models\Supplier;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $showDeleteModal = false;
    public $supplierToDelete;

    public function with(): array
    {
        return [
            'suppliers' => Supplier::orderByDesc('created_at')->paginate(15),
        ];
    }

    public function confirmDelete($id)
    {
        $this->supplierToDelete = Supplier::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $this->supplierToDelete->delete();
        $this->showDeleteModal = false;
        Toaster::success('Fornecedor deletado com sucesso!');
    }
}; ?>

<div class="overflow-x-auto">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Fornecedores') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Gerenciamento de fornecedores cadastrados') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('suppliers.create') }}" wire:navigate><flux:button class="mb-4" variant="primary">
            {{ __('Novo Fornecedor') }}
        </flux:button></a>

    <div class="overflow-hidden mb-3 rounded-lg border border-zinc-300 dark:border-zinc-700">
        <table class="min-w-full border-collapse">
            <thead>
            <tr>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    ID
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    Nome
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    E-mail
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    Telefone
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    CNPJ
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    Ação
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($suppliers as $supplier)
                <tr class="border-t border-zinc-300 dark:border-zinc-700">
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $supplier->id }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $supplier->name }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $supplier->email }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $supplier->phone }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $supplier->cnpj }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        <a href="{{ route('suppliers.edit', $supplier) }}" wire:navigate><flux:button size="sm">Editar</flux:button></a>
                        <flux:button size="sm" variant="danger" wire:click="confirmDelete({{ $supplier->id }})">Deletar</flux:button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <flux:modal wire:model="showDeleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Deletar Fornecedor?</flux:heading>
                <flux:text class="mt-2">
                    <p>Você está prestes a deletar este fornecedor.</p>
                    <p>Essa ação não poderá ser revertida.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="button" variant="danger" wire:click="delete">Deletar Fornecedor</flux:button>
            </div>
        </div>
    </flux:modal>

    {{ $suppliers->links() }}
</div>
