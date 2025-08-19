<?php

use App\Models\Product;
use App\Models\Client;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $showDeleteModal = false;
    public $productToDelete;

    public function with(): array {
        return [
            'products' => Product::orderByDesc('created_at')->paginate(15),
        ];
    }

    public function confirmDelete($id)
    {
        $this->productToDelete = Product::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $this->productToDelete->delete();
        $this->showDeleteModal = false;
        Toaster::success('Produto deletado com sucesso!');
    }
}; ?>

<div class="overflow-x-auto">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Produtos') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Gerenciamento de produtos cadastrados') }}</flux:subheading>
        <flux:separator variant="subtle"/>
    </div>

    <a href="{{ route('products.create') }}" wire:navigate>
        <flux:button class="mb-4" variant="primary">
            {{ __('Novo Produto') }}
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
                    Categoria
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    Fornecedor
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    Nome
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    Compra
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    Venda
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    QTD
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
            @foreach ($products as $product)
                <tr class="border-t border-zinc-300 dark:border-zinc-700">
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $product->id }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $product->category?->name }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $product->supplier?->name }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $product->name }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $product->buy_price_formatted }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $product->sell_price_formatted }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $product->quantity }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $product->status == 'active' ? 'Ativado' : 'Desativado' }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        <a href="{{ route('products.edit', $product) }}" wire:navigate>
                            <flux:button size="sm">Editar</flux:button>
                        </a>
                        <flux:button size="sm" variant="danger" wire:click="confirmDelete({{ $product->id }})">Deletar
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
                <flux:heading size="lg">Deletar Produto?</flux:heading>
                <flux:text class="mt-2">
                    <p>Você está prestes a deletar este produto.</p>
                    <p>Essa ação não poderá ser revertida.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer/>
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="button" variant="danger" wire:click="delete">Deletar Produto</flux:button>
            </div>
        </div>
    </flux:modal>

    {{ $products->links() }}
</div>
