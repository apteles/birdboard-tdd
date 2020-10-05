@extends('layouts.app')

@section('content')

    <h1>{{$project->title}}</h1>

    <div>{{$project->description}}</div>


    <a href="/projects">go back</a>

    <hr>
    <ul>

    @forelse($project->tasks as $task)

     <form method="POST" action="{{ $task->path() }}">

            @csrf
            @method('PATCH')


            <input value="{{ $task->body }}" type="text" name="body" />
            <input value="{{ $task->body }}" {{ $task->completed ? 'checked' : ''}} type="checkbox" name="completed" onChange="this.form.submit()" />

     </form>

    <br/>


    @empty

    @endforelse

        <form action="{{ $project->path() . '/tasks'}}" method="POST">
            @csrf
            <input style="border:1px solid #ddd;" type="text" name="body" placeholder="begin adding tasks..." />
        </form>
    </ul>
    <br/>
    <div>
        <form action="{{$project->path()}}" method="POST">
            @csrf
            @method('PATCH')
         <textarea style="min-height: 200px;border:1px solid #ddd;" name="notes">
            {{$project->notes}}
         </textarea>
         <br />
         <button type="submit" class="button" style="color: #333;">save</button>
        </form>
    </div>

@endsection
