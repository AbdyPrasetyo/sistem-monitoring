<?php

namespace App\Livewire;

use App\Models\Clients;
use Livewire\Component;

class Client extends Component
{
    public $clients, $client_id, $client_name, $phone_number, $email, $address;
    public $isModalOpen = false;


    public function mount()
    {
        $this->clients = Clients::all();
    }


    public function openCreateModal()
    {
        $this->resetFields();
        $this->isModalOpen = true;
    }


    public function openEditModal($id)
    {
        $client = Clients::find($id);
        $this->client_id = $client->id;
        $this->client_name = $client->client_name;
        $this->phone_number = $client->phone_number;
        $this->email = $client->email;
        $this->address = $client->address;
        $this->isModalOpen = true;
    }


    public function closeModal()
    {
        $this->resetFields();
        $this->isModalOpen = false;
    }


    public function resetFields()
    {
        $this->client_id = null;
        $this->client_name = '';
        $this->phone_number = '';
        $this->email = '';
        $this->address = '';
    }

    public function saveClient()
    {
        $this->validate([
            'client_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
        ]);

        if ($this->client_id) {

            $client = Clients::find($this->client_id);
            $client->update([
                'client_name' => $this->client_name,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                'address' => $this->address,
            ]);
        } else {

            Clients::create([
                'client_name' => $this->client_name,
                'phone_number' => $this->phone_number,
                'email' => $this->email,
                'address' => $this->address,
            ]);
        }

        $this->resetFields();
        $this->clients = Clients::all();
        $this->isModalOpen = false;
        session()->flash('message', $this->client_id ? 'Client updated successfully.' : 'Client created successfully.');
    }

    // Delete client
    public function deleteClient($id)
    {
        $client = Clients::find($id);
        $client->delete();
        $this->clients = Clients::all();
        session()->flash('message', 'Client deleted successfully.');
    }

    public function render()
    {
        return view('livewire.client');
    }
}
