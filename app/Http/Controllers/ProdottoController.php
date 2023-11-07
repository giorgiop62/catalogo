<?php

namespace App\Http\Controllers;

use App\Models\Prodotto;
use App\Models\Categoria;
use App\Models\CategoriaProdotto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class ProdottoController extends Controller
{
    /**
     * Questo metodo restituisce la lista dei prodotti e le categorie a loro associati.
     * Per recuperare le categorie associate a ciascun prodotto e renderle correttamente 
     * visibili in pagina, ho optato per utilizzare una mappa chiave valore, dove la chiave
     * è l'id del prodotto e il valore è la lista delle categorie associate al prodotto.
     * In questa maniera, in pagina, è risultato semplice recuperare le categorie tramite recupero 
     * diretto della mappa. 
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodotto = Prodotto::all();
        $mapCategorie = [];
        foreach($prodotto as $prod) {
            $categorie = $prod->categorie;
            $mapCategorie[$prod->id_prodotto] = $categorie;
        }
        return view('crud_prodotto/index', compact('prodotto', 'mapCategorie'));
    }

    /**
     * recupera la lista di tutte le categorie e resistuisce la vista per la creazione del prodotto
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Categoria::all();
        return view('crud_prodotto.create', compact('cat'));
    }

    /**
     * Persiste il nuovo prodotto creato nella base di dati.
     * Dopo aver effettuato la validazione e aver inserito il prodotto,
     * utilizzo l'id del prodotto appena creato per andare a salvare le righe nella
     * tabella associativa.
     * 
     * Poichè viene effettuato più di un inserimento nella stessa transazione, ho voluto 
     * gestire quest'ultima in modo da evitare incosistenze nel DB se una delle due operazioni
     * non andasse a buon fine. Questo perchè in caso di errori viene effettuato il rollback. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'nome' => 'required|max:100|',
                'prezzo' => 'required',
                'descrizione' => 'required',
                'categoriaOption' => 'required|array|min:1',
            ]);
             // Ho salvato il risultato della create per riempiere la tabella associativa con l'id del prodotto appena creato
            $prodotto = Prodotto::create([
                'nome' => $request->input('nome'),
                'prezzo' => $request->input('prezzo'),
                'descrizione' => $request->input('descrizione'),
            ]);

            foreach ($request->input('categoriaOption') as $categoriaId) {
                CategoriaProdotto::create([
                    'fk_categoria' => $categoriaId,
                    'fk_prodotto' => $prodotto->id_prodotto
                ]);
            }
            DB::commit();
             return redirect()->route('prodotto')
            ->with('success', ' Prodotto creato con successo.');
        
        } catch (\Exception $e) {
                DB::rollBack(); // Annulla la transazione in caso di errore
                return redirect()->route('prodotto')->with('error', 'Errore durante la creazione del prodotto');
            };
    }

    /**
     * Recupera la lista di tutte le categorie, recupera il prodotto e le categorie associate
     * al prodotto.
     * Mi serve recuperare le categorie associate per far si che risultino checked.
     * Infine restitusico la vista per la modifica del prodotto.
     *
     * @param  \App\Models\Prodotto  $prodotto
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $cat = Categoria::all();
        $prodotto = Prodotto::find($id);
        $categorieAssociate = $prodotto->categorie;
        return view('crud_prodotto.edit', compact('prodotto', 'cat','categorieAssociate'));
    }

    /**
     * Modifica il prodotto nella base di dati.
     * Dopo aver effettuato la validazione e aver modificato  il prodotto,
     * recupero le precedenti associazioni con le categorie e le cancello.
     * Dopodichè inserisco le nuove associazioni.
     * 
     * Poichè viene effettuato più di un inserimento nella stessa transazione, ho voluto 
     * gestire quest'ultima in modo da evitare incosistenze nel DB se una delle due operazioni
     * non andasse a buon fine. Questo perchè in caso di errori viene effettuato il rollback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prodotto  $prodotto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'nome' => 'required|max:100|',
                'prezzo' => 'required',
                'descrizione' => 'required',
                'categoriaOption' => 'required|array|min:1',
            ]);
            $prodotto = Prodotto::find($id);
            $prodotto->update([
                'nome' => $request->input('nome'),
                'prezzo' => $request->input('prezzo'),
                'descrizione' => $request->input('descrizione')
            ]);
            $categoriaProdotto = CategoriaProdotto::where('fk_prodotto', $id);
            $categoriaProdotto->delete();
            
            foreach ($request->input('categoriaOption') as $categoriaId) {
                CategoriaProdotto::create([
                    'fk_categoria' => $categoriaId,
                    'fk_prodotto' => $prodotto->id_prodotto
                ]);
            }
            DB::commit(); // Conferma la transazione

            return redirect()->route('prodotto')
                ->with('success', ' Prodotto modificato  con successo.');
         
        } catch(\Exception $e) {
            DB::rollBack(); // Annulla la transazione in caso di errore
                return redirect()->route('prodotto')->with('error', 'Errore durante la modifica del prodotto');
        }
    }

    /**
     * Rimuove il prodotto dalla base di dati.
     * Oltre al prodotto,vengono rimosse anche le righe dalla tabella associativa.
     * 
     * Poichè viene effettuata più di un 'operazione  nella stessa transazione, ho voluto 
     * gestire quest'ultima in modo da evitare incosistenze nel DB se una delle due operazioni
     * non andasse a buon fine. Questo perchè in caso di errori viene effettuato il rollback.
     *
     * @param  \App\Models\Prodotto  $prodotto
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();
            $prodotto = Prodotto::find($id);
            $categoriaProdotto = CategoriaProdotto::where('fk_prodotto', $id);
            $prodotto->delete();
            $categoriaProdotto->delete();
            DB::commit();
            return redirect()->route('prodotto')
              ->with('success', 'Prodotto eliminato con successo ');
        
        } catch(\Exception $e){
            DB::rollBack(); // Annulla la transazione in caso di errore
            return redirect()->route('prodotto')->with('error', 'Errore durante l\'eliminazione del prodotto');
        }
    }
}