<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class TodoList extends Component
{


    use WithPagination;

    #[Rule('required|min:3|max:50')]
    public $name;

    public $search;

    public $editingToDoId;

    #[Rule('required|min:3|max:50')]
    public $editingName;

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


    public function edit(Todo $todo)
    {
        $this->editingToDoId = $todo->id;
        $this->editingName = $todo->name;
    }

    public function update(Todo $todo)
    {
        $this->validateOnly('editingName');
        $todo->update([
            'name' => $this->editingName
        ]);
        // send flash message
        session()->flash('message', 'Item updated successfully!');
        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->reset('editingToDoId', 'editingName');
    }

    public function delete(Todo $todo)
    {
        $todo->delete();
    }

    public function toggle(Todo $todo)
    {
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function render()
    {
        $todos = Todo::latest()->where('name', 'like', "%{$this->search}%")->orderBy('completed', 'desc')->paginate(5);
        return view('livewire.todo-list', [
            'todos' => $todos
        ]);
    }
}
