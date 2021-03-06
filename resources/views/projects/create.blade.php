@extends('layouts.app')

@section('content')


    <form method="POST" action="/projects" class="container" >

        @csrf

    <h1 class="heading is-1">Create a project</h1>

        <div class="field">
            <label for="title" class="label">Title</label>
            <div class="control">
                <input type="text" class="input" name="title" placeholder="Title">
            </div>
        </div>

        <div class="field">
            <label for="description" class="label">Description</label>
            <div class="control">
                <textarea name="description" class="textarea"></textarea>
            </div>
        </div>

        <div class="field">
            <label for="description" class="label">Description</label>
            <div class="control">
                <button type="submit" class="button is-link">create project</button>
                <a href="/projects">cancel</a>
            </div>
        </div>

    </form>
@endsection
