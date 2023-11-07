<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaProdotto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


// ho scritto le funzioni per la crud di categoria
class CategoriaController extends Controller
{
    /**
     * Recupero una lista paginata delle categorie e restituisco la vista.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cat = Categoria::paginate(5);
        return view('crud_categoria/index', compact('cat'));
    }

    /**
     * Restituisce la vista per la creazione di una nuova categoria
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('crud_categoria.create');
    }

    /**
     * Persiste nel db la nuova risorsa creata.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|max:100|',
            'descrizione' => 'required',
          ]);
          Categoria::create($request->all());
          return redirect()->route('categoria')
            ->with('success', ' Categoria creata con successo.');
    }

    /**
     * Recupera la categoria tramite id e resistuisce la vista della modifica risorsa.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $cat = Categoria::find($id);
        return view('crud_categoria.edit', compact('cat'));
    }

    /**
     * Esegue un update della risosrsa modificata nel db
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'nome' => 'required|max:100|',
            'descrizione' => 'required',
        ]);
        $cat = Categoria::find($id);
        $cat->update($request->all());
        return redirect()->route('categoria')
        ->with('success', 'Categoria aggiornata con successo');
    }

    /**
     * Elimina la categoria dalla base di dati.
     * Oltre alla categoria vengono eliminate tutte le associazioni con i prodotti.
     * 
     * Poichè viene effettuata più di un 'operazione  nella stessa transazione, ho voluto 
     * gestire quest'ultima in modo da evitare incosistenze nel DB se una delle due operazioni
     * non andasse a buon fine. Questo perchè in caso di errori viene effettuato il rollback.
     * 
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();
            $cat = Categoria::find($id);
            $categoriaProdotto = CategoriaProdotto::where('fk_categoria', $id);
	        $cat->delete();
            $categoriaProdotto->delete();
            DB::commit(); // Conferma la transazione
	        return redirect()->route('categoria')
  	        ->with('success', 'Categoria eliminata con successo ');
    
        } catch(\Exception $e) {
            DB::rollBack(); // Annulla la transazione in caso di errore
            return redirect()->route('categoria')->with('error', 'Errore durante la creazione della categoria');
        }
        
    }
}
