<div>
    {{-- Do your work, then step back. --}}


    <button wire:click="openCreateModal" class="px-4 py-2 bg-green-500 text-white rounded-md mb-2">Add Client</button>
    <a href="{{ url('projects') }}" class="bg-gray-500 text-white py-2 px-4 mt-2 rounded">Back Projects</a>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Client Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Phone Number
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Address
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)



                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="border-b px-4 py-2">{{ $client->client_name }}</td>
                    <td class="border-b px-4 py-2">{{ $client->phone_number }}</td>
                    <td class="border-b px-4 py-2">{{ $client->email }}</td>
                    <td class="border-b px-4 py-2">{{ $client->address }}</td>
                    <td class="border-b px-4 py-2">
                        <button wire:click="deleteClient({{ $client->id }})" class="px-2 py-1 bg-red-500 text-white rounded-md">
                            <i class="fas fa-trash-alt w-5 h-5"></i>
                        </button>
                        <button wire:click="openEditModal({{ $client->id }})" class="px-2 py-1 bg-green-500 text-white rounded-md">
                            <i class="fas fa-edit w-5 h-5"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($isModalOpen)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
            <h2 class="text-2xl mb-4">{{ $client_id ? 'Edit Client' : 'Create Client' }}</h2>

            <form wire:submit.prevent="saveClient">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" for="client_name">Client Name</label>
                    <input wire:model="client_name" type="text" id="client_name" class="w-full p-2 border border-gray-300 rounded-md">
                    @error('client_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" for="phone_number">Phone Number</label>
                    <input wire:model="phone_number" type="text" id="phone_number" class="w-full p-2 border border-gray-300 rounded-md">
                    @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" for="email">Email</label>
                    <input wire:model="email" type="email" id="email" class="w-full p-2 border border-gray-300 rounded-md">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" for="address">Address</label>
                    <textarea wire:model="address" id="address" class="w-full p-2 border border-gray-300 rounded-md"></textarea>
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md ml-2">Save</button>
                </div>
            </form>
        </div>
    </div>
@endif


</div>
