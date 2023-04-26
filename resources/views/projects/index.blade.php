@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center">
    <h1>Progetti</h1>

    <!-- Stampo i pulsanti solo se mi trovo nella View 'Index' -->
    @if (request('trashed') == null)
    <div>
      <a href="{{ route('projects.create') }}" class="btn btn-primary">Nuovo Progetto</a>
      <!-- Creo un pulsante per cambiare Vista e passare al 'Cestino' in cui si troveranno tutti gli elementi eliminati -->
      <!-- Utilizzo la rotta 'Index', ma passando il paramentro 'trashed' per indicare il cambio di Vista -->
      <a href="{{ route('projects.index', ['trashed' => true]) }}" class="btn btn-dark">Cestino ({{ $num_trashed }})</a>
    </div>
    @endif

  </div>
</div>

<div class="container">

  <!-- Se esiste la Variabile di Sessione 'message', stampo il messaggio -->
  @if (request()->session()->exists('message'))
  <div class="alert alert-success" role="alert">
    {{ request()->session()->pull('message') }}
  </div>
  @endif

  <table class="table table-warning table-striped">
    <thead class="text-center">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nome</th>
        <!-- <th scope="col">Slug</th> -->
        <th scope="col">Descrizione</th>

        <!-- Aggiungo Colonna con il Nome della Tipologia -->
        <th scope="col">Tipologia</th>
        <th scope="col">Cliente</th>
        <th scope="col">URL</th>

        <!-- Stampo Colonna solo per i Cestinati -->
        @if (request('trashed'))
        <th scope="col">Eliminato</th>
        @endif

        <th scope="col">Azioni</th>
      </tr>
    </thead>

    <tbody>
      @forelse ($projects as $project)
      <tr>
        <td>{{$project->id}}</td>
        <td>
          <a href="{{ route('projects.show', $project) }}">{{$project->name}}</a>
        </td>
        <!-- <td>{{$project->slug}}</td> -->
        <td>{{$project->description}}</td>

        <!-- Posso leggere il Metodo 'type()' della Relazione, come Proprietà  -->
        <!-- Laravel farà la Query recuperando i dati della Tipologia relazionata (come Istanza) da cui recupero il 'nome'  -->
        <!-- ATTENZIONE: Operatore Ternario per controllo valori NULLI -->
        <td>{{ $project->type ? $project->type->name : 'Nessuna'}}</td>
        <td>{{$project->client}}</td>
        <td>{{$project->url}}</td>

        <!-- Stampo Colonna solo per i Cestinati -->
        @if (request('trashed'))
        <!-- Operatore Ternario: Se il Progetto e' stato eliminato stampo la Data di Eliminazione, altimenti nulla -->
        <td>{{ $project->trashed() ? $project->deleted_at->format('d/m/Y') : '' }}</td>
        @endif

        <td>
          <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">Modifica</a>

          <form class="my-2" action="{{ route('projects.destroy', $project) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Elimina</button>
          </form>

          @if ($project->trashed())
          <form action="{{ route('projects.restore', $project) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-success">Ripristina</button>
          </form>
          @endif
        </td>
      </tr>

      @empty
      <tr>
        <td colspan="6">Nessun Progetto Trovato</td>
      </tr>
      @endforelse
    </tbody>
  </table>

</div>
@endsection