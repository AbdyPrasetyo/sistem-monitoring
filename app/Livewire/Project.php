<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Clients;
use Livewire\Component;
use App\Models\Projects;
use Livewire\WithPagination;

class Project extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage  = 5;
    public $totalProgress = [];

    public $leaders, $clients;
    public $projectName, $leaderId, $clientId, $startDate, $endDate, $projectId;
    public $isModalOpen = false;

    protected $rules = [
        'projectName' => 'required|string|max:255',
        'leaderId' => 'required|exists:users,id',
        'clientId' => 'required|exists:clients,id',
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
    ];

    public function mount()
    {
        $this->leaders = User::all();
        $this->clients = Clients::all();
        $this->calculateTotalProgress();
    }
    public function openModal($projectId = null)
    {
        if ($projectId) {
            $project = Projects::findOrFail($projectId);
            $this->projectId = $project->id;
            $this->projectName = $project->project_name;
            $this->leaderId = $project->leader_id;
            $this->clientId = $project->client_id;
            $this->startDate = $project->start_date;
            $this->endDate = $project->end_date;
        } else {
            $this->resetFields();
        }

        $this->isModalOpen = true;
    }
    public function closeModal()
    {
        $this->resetFields();
        $this->isModalOpen = false;
    }

    private function resetFields()
    {
        $this->projectId = null;
        $this->projectName = '';
        $this->leaderId = '';
        $this->clientId = '';
        $this->startDate = '';
        $this->endDate = '';
    }




    public function createProject()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Projects::create([
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        session()->flash('message', 'Project successfully created!');
        $this->resetForm();
    }

    public function saveProject()
    {
        $this->validate();

        if ($this->projectId) {
            $project = Projects::find($this->projectId);
            $project->update([
                'project_name' => $this->projectName,
                'leader_id' => $this->leaderId,
                'client_id' => $this->clientId,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]);
        } else {
            Projects::create([
                'project_name' => $this->projectName,
                'leader_id' => $this->leaderId,
                'client_id' => $this->clientId,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]);
        }

        $this->closeModal();
    }


    public function deleteConfirmed($projectId)
    {
        $project = Projects::find($projectId);
        if ($project) {
            $project->delete();
            session()->flash('message', 'Project deleted successfully.');
            $this->projects = Projects::all();
        }
    }

    public function addLeader()
    {
        return redirect()->route('leader.index');
    }
    public function calculateTotalProgress()
    {
        $projects = Projects::with('tasks')->get();
        foreach ($projects as $project) {
            $tasks = $project->tasks;
            $totalTasks = $tasks->count();
            $completedTasks = $tasks->where('status', 'complete')->count();
            $inProgressTasks = $tasks->where('status', 'in progress')->count();
            $this->totalProgress[$project->id] = $totalTasks > 0
                ? (($completedTasks * 100) + ($inProgressTasks * 50)) / $totalTasks
                : 0;
        }
    }
    public function render()
    {

        $projects = Projects::with(['clients','leader'])->where('project_name', 'like', '%' . $this->search . '%')->paginate($this->perPage);
        return view('livewire.project', [
            'projects' => $projects,
            'totalProgress' => $this->totalProgress,
        ]);
    }
}
