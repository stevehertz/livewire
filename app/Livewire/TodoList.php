<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\Attributes\Rule;

class TodoList extends Component
{

    #[Rule('required|min:3|max:50')]
    
    public $name;

    public function create()  
    {
        // validate input
        $validated = $this->validateOnly('name');

        // create item
        Todo::create($validated);

        // clear input
        $this->reset('name');

        // send flash message
        session()->flash('message', 'Item created successfully!');

    }

    public function render()
    {
        $todos = Todo::latest()->get();
        return view('livewire.todo-list', [
            'todos' => $todos
        ]);
    }
}
