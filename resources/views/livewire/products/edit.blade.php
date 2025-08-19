<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $product;
    public $supplier_id, $category_id, $name, $description, $buy_price, $sell_price, $image, $quantity = 0, $status;

    public function with(): array
    {
        return [
            'suppliers' => Supplier::pluck('name', 'id'),
            'categories' => Category::pluck('name', 'id'),
        ];
    }

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->supplier_id = $product->supplier_id;
        $this->category_id = $product->category_id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->buy_price = $product->buy_price_formatted;
        $this->sell_price = $product->sell_price_formatted;
        $this->quantity = $product->quantity;
        $this->status = $product->status;
    }

    public function save()
    {
        $validated = $this->validate([
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:512',
            'buy_price' => 'nullable|string|max:255',
            'sell_price' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'quantity' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $validated['buy_price'] = formatPrice($validated['buy_price']);
        $validated['sell_price'] = formatPrice($validated['sell_price']);

        if ($this->image instanceof TemporaryUploadedFile) {
            if ($this->product->image) {
                Storage::delete($this->product->image);
            }
            $validated['image'] = $this->image->store('products');
        }

        $this->product->update($validated);

        Toaster::success('Produto editado com sucesso!');
        return redirect()->route('products.index');
    }

}; ?>

<div x-data x-init="
       const buy = IMask($refs.buy_price, {
         mask: 'R$ num',
         blocks: {
           num: {
             mask: Number,
             scale: 2,
             signed: false,
             thousandsSeparator: '.',
             radix: ',',
             mapToRadix: ['.']
           }
         },
         lazy: false
       });
       const sell = IMask($refs.sell_price, {
         mask: 'R$ num',
         blocks: {
           num: {
             mask: Number,
             scale: 2,
             signed: false,
             thousandsSeparator: '.',
             radix: ',',
             mapToRadix: ['.']
           }
         },
         lazy: false
       });
">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Editar Produto') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Preencha os dados abaixo') }}</flux:subheading>
        <flux:separator variant="subtle"/>
    </div>

    <form wire:submit.prevent="save" class="space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <flux:select label="Fornecedor" wire:model="supplier_id" required>
                <flux:select.option value="">-- Selecione --</flux:select.option>
                @foreach ($suppliers as $id => $name)
                    <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select label="Categoria" wire:model="category_id" required>
                <flux:select.option value="">-- Selecione --</flux:select.option>
                @foreach ($categories as $id => $name)
                    <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <flux:input label="Nome" wire:model="name" required/>
        <flux:textarea label="Descrição" wire:model="description"></flux:textarea>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <flux:input label="Preço de Compra" x-ref="buy_price" wire:model="buy_price"/>
            <flux:input label="Preço de Venda" x-ref="sell_price" wire:model="sell_price" required/>
        </div>
        <flux:input label="Alterar Imagem" type="file" wire:model="image"/>
        <div wire:loading wire:target="image">Enviando imagem...</div>
        <flux:input label="Quantidade em estoque" type="number" min="0" wire:model="quantity"/>
        <flux:select label="Situação" wire:model="status" required>
            <flux:select.option value="">-- Selecione --</flux:select.option>
            <flux:select.option value="active">Ativada</flux:select.option>
            <flux:select.option value="inactive">Desativada</flux:select.option>
        </flux:select>
        <flux:button type="submit" variant="primary">{{ __('Salvar') }}</flux:button>
    </form>
</div>
