<?php

namespace App\Livewire;

use Storage;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Leader extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $image, $name, $email, $userId;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'image' => 'nullable|image|max:1024',
    ];

    // public function mount()
    // {
    //     $this->leaders = User::all();
    // }

    public function saveLeader()
    {
        $this->validate();


        if ($this->image instanceof TemporaryUploadedFile) {
            $imageName = $this->image->storeAs('user', $this->image->getClientOriginalName(), 'public');
        } else {
            $imageName = null;
        }

        if ($this->userId) {

            $leader = User::find($this->userId);
            $leader->update([
                'name' => $this->name,
                'email' => $this->email,
                'image' => $imageName ?: $leader->image,
            ]);

        } else {

            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'image' => $imageName,
            ]);

        }

        $this->closeModal();
        session()->flash('message', $this->userId ? 'Leader updated successfully!' : 'Leader created successfully!');
    }

    public function openModal($userId = null)
    {
        if ($userId) {

            $user = User::findOrFail($userId);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->image = $user->image;
        } else {

            $this->resetFields();
        }

        $this->isModalOpen = true;
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->userId = null;
        $this->image = null;
    }

    public function closeModal()
    {

        $this->isModalOpen = false;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->image) {
            Storage::disk('public')->delete('user/' . $user->image);
        }

        $user->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $leaders = User::paginate(5);
        return view('livewire.leader', compact('leaders')
        );
    }
}
