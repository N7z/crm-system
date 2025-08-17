<?php

use App\Models\Category;
use App\Models\Client;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $showDeleteModal = false;
    public $categoryToDelete;

    public function with(): array
    {
        return [
            'categories' => Category::orderByDesc('created_at')->paginate(15),
        ];
    }

    public function confirmDelete($id)
    {
        $this->categoryToDelete = Category::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $this->categoryToDelete->delete();
        $this->showDeleteModal = false;
        Toaster::success('Categoria deletada com sucesso!');
    }
}; ?>

<div class="overflow-x-auto">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Categorias') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Gerenciamento de categorias cadastrados') }}</flux:subheading>
        <flux:separator variant="subtle"/>
    </div>

    <a href="{{ route('categories.create') }}" wire:navigate>
        <flux:button class="mb-4" variant="primary">
            {{ __('Nova Categoria') }}
        </flux:button>
    </a>

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
                    Situação
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    Ação
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
                <tr class="border-t border-zinc-300 dark:border-zinc-700">
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $category->id }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $category->name }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $category->status == 'active' ? 'Ativada' : 'Desativada' }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        <a href="{{ route('categories.edit', $category) }}" wire:navigate>
                            <flux:button size="sm">Editar</flux:button>
                        </a>
                        <flux:button size="sm" variant="danger" wire:click="confirmDelete({{ $category->id }})">Deletar
                        </flux:button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <flux:modal wire:model="showDeleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Deletar Categoria?</flux:heading>
                <flux:text class="mt-2">
                    <p>Você está prestes a deletar esta categoria.</p>
                    <p>Essa ação não poderá ser revertida.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer/>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="button" variant="danger" wire:click="delete">Deletar Categoria</flux:button>
            </div>
        </div>
    </flux:modal>

    {{ $categories->links() }}
</div>
