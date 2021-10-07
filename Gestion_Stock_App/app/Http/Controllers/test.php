<?php
    class test extends Controller{
        public function index()
        {    
            $store = Auth::user()->store;
            //Demandes du magasin
            $c = DB::table('demande_store')
                ->select('demande_id')
                ->where('store_id', $store->id)
                ->distinct()
                ->get();
            $array = array();
            foreach($c as $s){
              array_push($array, $s->demande_id);
            }
            $demandes = Demande::whereIn('id',$array)->get();
            //Commandes du magasin
            $c1 = DB::table('commande_store')
                ->select('commande_id')
                ->where('store_id', $store->id)
                ->distinct()
                ->get();
             $array1 = array();
             foreach($c1 as $s1){
                 array_push($array1, $s1->commande_id);
             }
            $commandes = Commande::whereIn('id',$array1)->get();
            //Demandes-Commandes chart
            $year = date("Y");
            $data = array();
            $data1 = array();
            $from = "";
            $to = "";
            for($i=0; $i<12; $i++){
                $month = $i+1;
                $from = "$year-$month-01";
                $to = "$year-$month-31";
                array_push($data, $demandes->whereBetween('created_at', [$from, $to])->count());
                array_push($data1, $commandes->whereBetween('created_at', [$from, $to])->count());
            }
            $chart = new Ex1();
            $chart->labels(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre']);
            $chart->dataset('Demandes', 'line', $data)->options([
                'fill' => 'true',
                'backgroundColor' => '#51C1C0'
            ]);
            $chart->dataset('Commandes', 'line', $data1)->options([
                'fill' => 'true',
                'backgroundColor' => '#5c85d6'
            ]);
            $chart->title("Demandes/Commandes Mensuelles du magasin", 18, '#0098ac', true, "'Helvetica Neue', 'Helvetica', 'Arial'");
            return view('home',compact('chart'));
           //dd($data, $from, $to, $demandes);
        }


        public function verifie(Demande $demande){
            $fields = DB::table('demande_product')
                    ->where('demande_id', $demande->id)
                    ->get();
            foreach($fields as $field){
                $p = DB::table('product_store')
                    ->where('store_id', $field->store_id)
                    ->where('product_id', $field->product_id)
                    ->get();
                if(is_null($p)){
                    DB::table('product_store')->insert([
                        'quantite_reel'=>$field->quantite, 'product_id'=>$field->product_id, 'store_id'=>$field->store_id
                    ]);
                }
            }
            $montant_paye = request('montant_paye');
            $mode_payment = request('mode_payment');
            Paiement::create([
                'demande_id'=>$demande->id, 'mode_paiement'=>$mode_payment, 'montant_paye'=>$montant_paye
            ]);
            $credit = $demande->total - $montant_paye;
            $client = $demande->client; 
            $client->credit += $credit;
            $client->save();
            $demande->update([
                 'credit'=>$credit, 'delivre'=>1,
            ]);
    
            return back();
        }

        public function verifie1(Demande $demande){
            $fields = DB::table('demande_product')
                    ->where('demande_id', $demande->id)
                    ->get();
            $array = array();
            foreach($fields as $field){
                $p = DB::table('product_store')
                    ->where('store_id', $field->store_id)
                    ->where('product_id', $field->product_id)
                    ->first();
                if(is_null($p)){
                    return back()->with('error', "Magasin $field->store_id n'a pas les produits demandés");
                }
                if($field->quantite > $p->quantite_reel){
                    return back()->with('error', "Magasin $field->store_id n'a pas la quantité demandée");
                }
                    array_push($array, $p);
            }
            foreach ($array as $a) {
                $field = $fields->where('product_id', $a->product_id)
                                ->where('store_id', $a->store_id)
                                ->first();
                $a->quantite_reel = $a->quantite_reel - $field->quantite;
                $a->save();
            }
            
            DB::table('product_store')
            ->where('store_id', $field->store_id)
            ->where('product_id', $field->product_id)
            ->update([
                'quantite_reel'=>$p->quantite_reel-$field->quantite,
            ]);
    
            $montant_paye = request('montant_paye');
            $mode_payment = request('mode_payment');
            Paiement::create([
                'demande_id'=>$demande->id, 'mode_paiement'=>$mode_payment, 'montant_paye'=>$montant_paye
            ]);
            $credit = $demande->total - $montant_paye;
            $client = $demande->client; 
            $client->credit += $credit;
            $client->save();
            $demande->update([
                 'credit'=>$credit, 'delivre'=>1,
            ]);
    
            return back();
        }
        function f(){
                    $entree = Paiement::whereNotNull('demande_id')->whereBetween('created_at', [$from, $to])->sum('montant_paye');    
        $sortie = Paiement::whereNotNull('commande_id')->whereBetween('created_at', [$from, $to])->sum('montant_paye'); 
        }

    }