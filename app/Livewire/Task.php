<?php

namespace App\Livewire;

use App\Models\Tasks;
use Livewire\Component;
use App\Models\Projects;
use Livewire\WithPagination;

class Task extends Component
{
    use WithPagination;

    public $taskId, $project_id, $title, $status;
    public $isModalOpen = false;
    public $isCreateMode = true;

    public $projects;

    #[Computed()]
    function listProjects() {
        return Projects::orderBy('project_name','asc')->get();
    }

    public function render()
    {
        $tasks = Tasks::paginate(5);
        return view('livewire.task', compact('tasks'));
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->isCreateMode = true;
        $this->isModalOpen = true;
    }

    public function openEditModal($taskId)
    {
        $this->isCreateMode = false;
        $task = Tasks::find($taskId);
        $this->taskId = $task->id;
        $this->project_id = $task->project_id;
        $this->title = $task->title_task;
        $this->status = $task->status;
        $this->isModalOpen = true;
    }


    public function closeModal()
    {
        $this->isModalOpen = false;

    }
    public function saveTask()
    {
        $this->validate([
            'project_id' => 'required',
            'title' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($this->isCreateMode) {
            Tasks::create([
                'project_id' => $this->project_id,
                'title_task' => $this->title,
                'status' => $this->status,
            ]);
        } else {
            $task = Tasks::find($this->taskId);
            $task->update([
                'project_id' => $this->project_id,
                'title_task' => $this->title,
                'status' => $this->status,
            ]);
        }

        $this->resetFields();
        $this->isModalOpen = false;
    }

    public function deleteTask($taskId)
    {
        Tasks::find($taskId)->delete();
    }

    public function resetFields()
    {
        $this->taskId = null;
        $this->project_id = '';
        $this->title = '';
        $this->status = '';
    }
}
