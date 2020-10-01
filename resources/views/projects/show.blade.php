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



    @empty

    @endforelse

        <form action="{{ $project->path() . '/tasks'}}" method="POST">
            @csrf
            <input type="text" name="body" placeholder="begin adding tasks..." />
        </form>
    </ul>

@endsection
