<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}


    <button wire:click="openCreateModal" class="px-4 py-2 bg-blue-500 text-white rounded-md">Add Task</button>
    <a href="{{ url('projects') }}" class="bg-gray-500 text-white py-2 px-4 mt-2 rounded">Back Projects</a>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-2">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="border-b px-4 py-2">Project</th>
                <th class="border-b px-4 py-2">Title</th>
                <th class="border-b px-4 py-2">Status</th>
                <th class="border-b px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="border-b px-4 py-2">{{ $task->projects->project_name }}</td>
                    <td class="border-b px-4 py-2">{{ $task->title_task }}</td>
                    <td class="border-b px-4 py-2">{{ $task->status }}</td>
                    <td class="border-b px-4 py-2">
                        <button wire:click="deleteTask({{ $task->id }})" class="px-2 py-1 bg-red-500 text-white rounded-md"> <i class="fas fa-trash-alt w-5 h-5"></i></button>
                        <button wire:click="openEditModal({{ $task->id }})" class="px-2 py-1 bg-green-500 text-white rounded-md"> <i class="fas fa-edit w-5 h-5"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



@if($isModalOpen)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-1/2">
        <h2 class="text-2xl mb-4" x-show="isCreateMode">{{ $taskId ? 'Edit' : 'Create' }}</h2>

        <form wire:submit.prevent="saveTask">


            <div class="mb-4">
                <label class="block text-sm font-medium mb-2" for="leaderId">Projects</label>
                <select id="leaderId" wire:model="project_id" class="w-full p-2 border rounded">
                    <option value="">Select Projects</option>
                    @if ($this->listProjects())
                    @foreach ($this->listProjects() as $project)
                                                   <option value="{{ $project->id}}">{{$project->project_name}}</option>
                                                @endforeach
                                            @endif
                </select>
                @error('project_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>



            <div class="mb-4">
                <label for="title" class="block mb-2">Title</label>
                <input wire:model="title" type="text" id="title" class="w-full p-2 border border-gray-300 rounded-md">
            </div>


            <div class="mb-4">
                <label class="block text-sm font-medium mb-2" for="status">Status</label>
                <select id="status" wire:model="status" class="w-full p-2 border rounded">
                    <option>Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="in progress">In Progress</option>
                        <option value="complete">Complete</option>
                </select>
                @error('leaderId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
