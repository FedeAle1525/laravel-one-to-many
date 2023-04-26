<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  Aggiungo paramentro '$request' per recuperare tutti i dati passati con la Richiesta
    public function index(Request $request)
    {
        // Recupero il paramentro 'trashed' passato con la richiesta
        $trashed = $request->input('trashed');

        // Se il Parametro 'trashed' esiste (=1) recupero solo gli elementi cestinati, altrimenti tutti gli altri (senza i cestinati)
        if ($trashed) {

            $projects = Project::onlyTrashed()->get();
        } else {

            $projects = Project::all();
        }

        // Eseguo la Query per contare quanti solo gli elementi eliminati
        // Poi lo passo come paramentro per usarlo come Contatore del Cestino
        $num_trashed = Project::onlyTrashed()->count();

        // Recupero tutti gli elementi dal DB inclusi quelli "cestinati"
        // $projects = Project::withTrashed()->get();

        return view('projects.index', compact('projects', 'num_trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Recupero tutte le Tipologie dal DB e le passo alla Vista
        $types = Type::orderBy('name', 'asc')->get();

        return view('projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {

        // In $request ho già i dati compresi di validazione
        $data = $request->validated();

        // All'interno di $request non ho il valore 'slug' da inserire nel DB, perche' viene generato in automatico e
        // e non inserito da Utente nel Form quindi devo inserirlo manualmente per evitare errore
        $data['slug'] = Str::slug($data['name']);

        // Aggiungere variabile $fillable in Model per usare 'create'
        $project = Project::create($data);

        return to_route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

        // Recupero tutte le Tipologie dal DB e le passo alla Vista
        $types = Type::orderBy('name', 'asc')->get();

        return view('projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        // In $request ho già i dati compresi di validazione
        $data = $request->validated();

        // All'interno di $request non ho il valore 'slug' da inserire nel DB, perche' viene generato in automatico e
        // e non inserito da Utente nel Form quindi devo inserirlo manualmente per evitare errore
        // In caso di modifica titolo ricreo lo 'slug'
        if ($data['name'] !== $project['name']) {
            $data['slug'] =  Str::slug($data['name']);
        }

        // Modifico i valori del Progetto ($project) con quelli presenti nella Request ($data) ottenuti vdal Form
        $project->update($data);

        return to_route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->trashed()) {

            // Eliminazione definitiva
            $project->forceDelete();

            // All'interno della Sessione creo una variable messaggio che verra' mostrato al completamento dell'operazione
            request()->session()->put('message', "Il Progetto e' stato eliminato definitivamente");
        } else {

            // Eliminazione SoftDelete
            $project->delete();

            // All'interno della Sessione creo una variable messaggio che verra' mostrato al completamento dell'operazione
            request()->session()->put('message', "Il Progetto e' stato spostato nel cestino");
        }

        // Rindirizza alla stessa pagina dove e' stato invocato il metodo (Index o Cestino)
        return back();
    }

    // Metodo per il Ripristino di un Elemento
    public function restore(Project $project)
    {

        // Ripristino l'Elemento solo se e' stato precedentemente eliminato
        if ($project->trashed()) {

            $project->restore();

            // All'interno della Sessione creo una variable messaggio che verra' mostrato al completamento dell'operazione
            request()->session()->put('message', "Il Progetto e' stato ripristinato con successo");
        }

        // Rindirizza alla stessa pagina dove e' stato invocato il metodo (Index o Show)
        return back();
    }
}
