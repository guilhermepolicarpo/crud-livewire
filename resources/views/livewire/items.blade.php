<div class="p-6 sm:px-10 bg-white border-b border-gray-200">
    <!--<div class="mt-6">-->
        <div class="flex justify-end">

                <x-jet-button wire:click="confirmItemAdd">
                    {{ __('Add New Item') }}
                </x-jet-button>


        </div>
        <div class="mt-6">
            <div class="flex justify-start items-center">
                <div>
                    <input wire:model.debounce.500ms="q" type="search" placeholder="Search" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mr-2 ml-2">
                    <input type="checkbox" class="mr-2 leading-tight" wire:model="active" /> Active Only?
                </div>
            </div>
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button class="font-bold" wire:click="sortBy('id')">ID</button>
                            <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button class="font-bold" wire:click="sortBy('name')">Name</button>
                            <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button class="font-bold" wire:click="sortBy('price')">Price</button>
                            <x-sort-icon sortField="price" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        Status
                    </th>
                    <th class="px-4 py-2">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td class="border px-4 py-2">{{ $item->id }}</td>
                    <td class="border px-4 py-2">{{ $item->name }}</td>
                    <td class="border px-4 py-2">{{ number_format($item->price, 2, ',') }}</td>
                    <td class="border px-4 py-2">{{ $item->status ? 'Active' : 'Not-Active' }}</td>
                    <td class="border px-4 py-2">
                        <x-jet-button wire:click="confirmItemEdit({{ $item->id }})" wire:loading.attr="disabled">
                            <x-action-icon action="edit" />
                        </x-jet-button>
                        <x-jet-danger-button wire:click="confirmItemDeletion({{ $item->id }})" wire:loading.attr="disabled">
                            <x-action-icon action="delete" />
                        </x-jet-danger-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $items->links() }}
        </div>
    <!--</div>-->

    <!-- Delete Item Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="deleteItem({{ $confirmingItemDeletion }})" wire:loading.attr="disabled">
                {{ __('Delete Item') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Add Item Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingItemAdd">
        <x-slot name="title">
            {{ isset($this->item->id) ? __('Edit Item') : __('Add Item') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="item.name" />
                <x-jet-input-error for="item.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-jet-label for="price" value="{{ __('Price') }}" />
                <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.defer="item.price" />
                <x-jet-input-error for="item.price" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 mt-4">
                <label for="status" class="flex items-center">
                    <input id="status" type="checkbox" class="form-checkbox" wire:model.defer="item.status">
                    <span class="ml-2 text-sm text-gray-600">Active</span>
                </label>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-3" wire:click="addItem()" wire:loading.attr="disabled">
                {{ isset($this->item->id) ? __('Edit Item') : __('Add Item') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

