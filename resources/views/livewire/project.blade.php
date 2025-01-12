<div>
<div class="relative overflow-x-auto">


    <div class="flex justify-between items-center mb-4">
        <div class="flex items-center">
            <span class="mr-2">Show</span>
            <select wire:model.live="perPage" >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">15</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="ml-2">entries per page</span>
        </div>

        <div class="flex items-center">
            <input type="text" wire:model.live="search" placeholder="Search Project..." class="px-4 py-2 border rounded">
        </div>
    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-2">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
               PROJECT NAME
                </th>
                <th scope="col" class="px-6 py-3">
                    CLIENT
                </th>
                <th scope="col" class="px-6 py-3">
                    PROJECT LEADER
                </th>
                <th scope="col" class="px-6 py-3">
                    START DATE
                </th>
                <th scope="col" class="px-6 py-3">
                    END DATE
                </th>
                <th scope="col" class="px-6 py-3">
                    PROGRESS
                </th>
                <th scope="col" class="px-6 py-3">
                    ACTION
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{ $project->project_name }}
                </th>
                <td class="px-6 py-4">
                    {{ $project->clients->client_name }}
                </td>
                <td class="px-6 py-4 flex items-center">
                    <img class="w-10 h-10 rounded-full mr-4" src="{{ asset('storage/' .$project->leader->image) }}" alt="{{ $project->leader->name }}">
                    <div class="text-sm">
                        <p class="text-gray-900 leading-none">{{ $project->leader->name }}</p>
                        <p class="text-gray-600">{{ $project->leader->email }}</p>
                    </div>
                </td>
                <td class="px-6 py-4">
                {{ \Carbon\Carbon::parse($project->start_date)->format('d F Y') }}
                </td>
                <td class="px-6 py-4">
                    {{ \Carbon\Carbon::parse($project->end_date)->format('d F Y') }}
                </td>
                <td class="px-6 py-4">
                    @if(isset($totalProgress[$project->id]))
                    <div class="relative pt-1">

                        <div class="flex items-center">
                            <div class="h-2 bg-gray-200 rounded flex-grow relative">
                                <div
                                    class="bg-blue-600 h-full rounded"
                                    style="width: {{ $totalProgress[$project->id] }}%; transition: width 0.3s;">
                                </div>
                            </div>
                            <span class="ml-2 text-xs font-semibold text-blue-600">
                                {{ round($totalProgress[$project->id], 2) }}%
                            </span>
                        </div>
                    </div>
                @else
                    <span class="text-gray-500 italic">No tasks available</span>
                @endif


                </td>
                <td class="px-6 py-4">



                    <button wire:click="deleteConfirmed({{ $project->id }})"  class="px-2 py-1 bg-red-500 text-white rounded-md">
                        <i class="fas fa-trash-alt w-5 h-5"></i>
                    </button>
                    <button wire:click="openModal({{ $project->id }})"  class="px-2 py-1 bg-green-500 text-white rounded-md">
                        <i class="fas fa-edit w-5 h-5"></i>
                    </button>
                </td>


            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        <a href="{{ url('clients') }}"  class="bg-gray-500 text-white py-2 px-4 rounded"> Add Clients</a>
        <a href="{{ url('leader') }}"  class="bg-blue-500 text-white py-2 px-4 rounded" > Add Leaders</a>
        <button wire:click="openModal" class="bg-green-500 text-white py-2 px-4 rounded">Add New Project</button>
        <a href="{{ url('tasks') }}"  class="bg-yellow-500 text-white py-2 px-4 rounded"> Add Tasks</a>
    </div>
</div>
<div class="mt-4">
    {{ $projects->links() }}
</div>


@if($isModalOpen)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 max-w-lg">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">{{ $projectId ? 'Edit Project' : 'Add New Project' }}</h2>

        <form wire:submit.prevent="saveProject">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="projectName">Project Name</label>
                <input type="text" id="projectName" wire:model="projectName" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('projectName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="leaderId">Leader</label>
                <select id="leaderId" wire:model="leaderId" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Leader</option>
                    @foreach($leaders as $leader)
                        <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                    @endforeach
                </select>
                @error('leaderId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="clientId">Client</label>
                <select id="clientId" wire:model="clientId" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                    @endforeach
                </select>
                @error('clientId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="startDate">Start Date</label>
                <input type="date" id="startDate" wire:model="startDate" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="endDate">End Date</label>
                <input type="date" id="endDate" wire:model="endDate" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <button type="button" wire:click="closeModal" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">{{ $projectId ? 'Update Project' : 'Create Project' }}</button>
            </div>
        </form>
    </div>
</div>
@endif

</div>

