<div>
    <button wire:click="openModal" class="bg-green-500 text-white py-2 px-4 mt-2 rounded">Add New Leader</button>
<a href="{{ url('projects') }}" class="bg-gray-500 text-white py-2 px-4 mt-2 rounded">Back Projects</a>
@if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('message') }}</span>
    </div>
@endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg mt-2">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left">Image</th>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaders as $leader)
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            @if($leader->image)
                                <img src="{{ asset('storage/' .$leader->image) }}" alt="Leader Image" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <span class="text-gray-500">No Image</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $leader->name }}</td>
                        <td class="px-4 py-2">{{ $leader->email }}</td>
                        <td class="px-4 py-2">
                            <button wire:click="delete({{ $leader->id }})"  class="px-2 py-1 bg-red-500 text-white rounded-md">
                                <i class="fas fa-trash-alt w-5 h-5"></i>
                            </button>
                            <button wire:click="openModal({{ $leader->id }})"  class="px-2 py-1 bg-green-500 text-white rounded-md">
                                <i class="fas fa-edit w-5 h-5"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>



    </div>

    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" style="display: {{ $isModalOpen ? 'flex' : 'none' }};">
        <div class="bg-white p-6 rounded-lg w-full sm:w-96 max-w-lg">
            <h2 class="text-xl font-semibold text-gray-700 mb-6">{{ $userId ? 'Edit' : 'Create' }} Leader</h2>

            <form wire:submit.prevent="saveLeader">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model="email" id="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                    <input type="file" wire:model="image" id="image" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" />
                    @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" wire:click="closeModal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
                </div>
            </form>
        </div>
    </div>

</div>
