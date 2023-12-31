<div>
    @include('livewire.includes.create')

    @include('livewire.includes.search')

    <div id="todos-list">
        
        @foreach ($todos as $todo)
            @include('livewire.includes.list')
        @endforeach

        <div class="my-2">
            {{ $todos->links() }}
        </div>
    </div>

</div>
