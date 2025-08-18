<?php

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-neutral-200 dark:border-zinc-700 p-4">
                <p class="text-sm text-gray-500 dark:text-gray-200">Vendas Hoje</p>
                <p class="text-2xl font-bold">R$ 1.200</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-zinc-700 p-4">
                <p class="text-sm text-gray-500 dark:text-gray-200">Produtos Vendidos</p>
                <p class="text-2xl font-bold">35</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-zinc-700 p-4">
                <p class="text-sm text-gray-500 dark:text-gray-200">Lucro</p>
                <p class="text-2xl font-bold">R$ 800</p>
            </div>
        </div>

        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-zinc-700">
            <div class="p-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold">Últimas Vendas</h2>
                <flux:modal.trigger name="nova-venda">
                    <flux:button variant="primary">Nova Venda</flux:button>
                </flux:modal.trigger>
            </div>

            <div class="mb-3 rounded-lg p-4">
                <table class="min-w-full border-collapse">
                    <thead>
                    <tr>
                        <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left">Cliente</th>
                        <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left">Qtd</th>
                        <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left">Preço</th>
                        <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left">Total</th>
                        <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Exemplo de linha -->
                    <tr class="border-t border-zinc-300 dark:border-zinc-700">
                        <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700">Cliente Exemplo</td>
                        <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700">2</td>
                        <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700">R$ 50</td>
                        <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700">R$ 100</td>
                        <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700">
                            <flux:button size="sm" variant="danger">Deletar</flux:button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <flux:modal name="nova-venda" class="md:w-5/6" x-data="{
            products: {
                1: {name: 'Produto A', price: 50, selected: false, quantity: 1},
                2: {name: 'Produto B', price: 30, selected: false, quantity: 1}
            },
            get subtotal() {
                return Object.values(this.products)
                    .filter(p => p.selected)
                    .reduce((acc, p) => acc + p.price * p.quantity, 0);
            },
            format(v) {
                return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v);
            }
        }"
    >
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Criar Venda</flux:heading>
                <flux:text class="mt-2">Selecione o cliente e os produtos da venda.</flux:text>
            </div>

            <form class="space-y-6">
                <flux:select label="Cliente" name="client_id" required>
                    <option value="1">Cliente 1</option>
                    <option value="2">Cliente 2</option>
                </flux:select>

                <div class="space-y-2">
                    <label class="font-medium text-sm">Produtos</label>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-zinc-700">
                            <tr>
                                <th class="px-3 py-2"></th>
                                <th class="px-3 py-2 text-start">Produto</th>
                                <th class="px-3 py-2 text-start">Preço</th>
                                <th class="px-3 py-2 text-start w-24">Qtd</th>
                                <th class="px-3 py-2 text-start">Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-center border border-neutral-200 dark:border-zinc-700">
                                    <flux:checkbox class="mx-auto" x-model="products[1].selected" />
                                </td>
                                <td class="px-3 py-2 border border-neutral-200 dark:border-zinc-700">Produto A</td>
                                <td class="px-3 py-2 border border-neutral-200 dark:border-zinc-700">R$ 50</td>
                                <td class="px-3 py-2 border border-neutral-200 dark:border-zinc-700">
                                    <flux:input type="number" min="1" size="sm" x-model.number="products[1].quantity"/>
                                </td>
                                <td class="px-3 py-2 border border-neutral-200 dark:border-zinc-700"
                                    x-text="products[1].selected ? format(products[1].price * products[1].quantity) : '-'">
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-center border border-neutral-200 dark:border-zinc-700">
                                    <flux:checkbox class="mx-auto" x-model="products[2].selected" />
                                </td>
                                <td class="px-3 py-2 border border-neutral-200 dark:border-zinc-700">Produto B</td>
                                <td class="px-3 py-2 border border-neutral-200 dark:border-zinc-700">R$ 30</td>
                                <td class="px-3 py-2 border border-neutral-200 dark:border-zinc-700">
                                    <flux:input type="number" min="1" size="sm" x-model.number="products[2].quantity"/>
                                </td>
                                <td class="px-3 py-2 border border-neutral-200 dark:border-zinc-700"
                                    x-text="products[2].selected ? format(products[2].price * products[2].quantity) : '-'">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end items-center">
                    <span class="mr-4 font-medium">Total:</span>
                    <span class="text-lg font-bold text-gray-700 dark:text-white" x-text="format(subtotal)"></span>
                </div>

                <div class="flex gap-2">
                    <flux:spacer/>
                    <flux:modal.close>
                        <flux:button type="button" variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Salvar Venda</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
