@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
  <h1 class="mb-4">{{ $project->name }}</h1>

  <p>{{ $project->description }}</p>
</div>

<div class="container">
  <ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-start">
      <div class="ms-2 me-auto">
        <div class="fw-bold">Slug</div>
        {{ $project->slug }}
      </div>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-start">
      <div class="ms-2 me-auto">
        <div class="fw-bold">Cliente</div>
        {{ $project->client }}
      </div>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-start">
      <div class="ms-2 me-auto">
        <div class="fw-bold">URL</div>
        @if ($project->url == null)
        Nessun URL
        @else
        {{ $project->url }}
        @endif
      </div>
    </li>
  </ul>
</div>

<div class="container py-3 d-flex justify-content-center gap-2">
  <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">Modifica</a>

  @if ($project->trashed())
  <form action="{{ route('projects.restore', $project) }}" method="post">
    @csrf
    <button type="submit" class="btn btn-success">Ripristina</button>
  </form>
  @endif
</div>


@endsection