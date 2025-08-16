<?php

use App\Models\Client;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $showDeleteModal = false;
    public $clientToDelete;

    public function with(): array
    {
        return [
            'clients' => Client::orderByDesc('created_at')->paginate(15),
        ];
    }

    public function confirmDelete($id)
    {
        $this->clientToDelete = Client::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $this->clientToDelete->delete();
        $this->showDeleteModal = false;
        Toaster::success('Cliente deletado com sucesso!');
    }
}; ?>

<div class="overflow-x-auto">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Clientes') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Gerenciamento de clientes cadastrados') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button class="mb-4" variant="primary" onclick="window.location.href='{{ route('clients.create') }}'">
        {{ __('Novo Cliente') }}
    </flux:button>

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
                    CPF
                </th>
                <th class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-left text-zinc-800 dark:text-zinc-200">
                    Ação
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($clients as $client)
                <tr class="border-t border-zinc-300 dark:border-zinc-700">
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $client->id }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $client->name }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $client->email }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $client->phone }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        {{ $client->cpf }}
                    </td>
                    <td class="px-4 py-2 border-r border-zinc-300 dark:border-zinc-700 text-zinc-900 dark:text-zinc-200">
                        <flux:button size="sm" onclick="window.location.href='{{ route('clients.edit', $client) }}'">Editar</flux:button>
                        <flux:button size="sm" variant="danger" wire:click="confirmDelete({{ $client->id }})">Deletar</flux:button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <flux:modal wire:model="showDeleteModal" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Deletar Cliente?</flux:heading>
                <flux:text class="mt-2">
                    <p>Você está prestes a deletar este cliente.</p>
                    <p>Essa ação não poderá ser revertida.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="button" variant="danger" wire:click="delete">Deletar Cliente</flux:button>
            </div>
        </div>
    </flux:modal>

    {{ $clients->links() }}
</div>
