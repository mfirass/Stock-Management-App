<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Charts\Ex1;
use DB;
use App\Demande;
use App\Commande;
use App\Category;
use App\Charge;
use App\Paiement;
use App\Employee;
use App\Client;
use App\Fournisseur;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {    /*
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
        $data = array();
        $data1 = array();
        $year = date('Y');
        for($i = 0; $i < 12; $i++){
            $month = $i+1;
            $from = "$year-$month-01";
            $to = "$year-$month-31";
            if($month < 10){
                $from = "$year-0$month-01";
                $to = "$year-0$month-31";
            }

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

        //Charges
        $charges = Charge::where('store_id', Auth::user()->store->id)->first();
        $salaire = Employee::where('store_id', Auth::user()->store->id)->sum('salaire');

        return view('home',compact('chart','charges', 'salaire'));*/
       //dd($data, $from, $to, $demandes);
       return redirect()->route('user.produits');
    }

    public function adminHome()
    {   
        //Demandes-Commandes chart
        $y = date("Y");
        $data = array();
        $data1 = array();
        for($i=0; $i<12; $i++){
            $n = $i+1;
            $from = "$y-$n-01";
            $to = "$y-$n-31";
            $nb = Demande::whereBetween('created_at', [$from, $to])->count();
            $nb1 = Commande::whereBetween('created_at', [$from, $to])->count();
            array_push($data, $nb);
            array_push($data1, $nb1);
        }
        $chart = new Ex1();
        $chart->labels(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre']);
        $chart->dataset('Demandes', 'line', $data)->options([
            'fill' => 'true',
            'backgroundColor' => '#51C1C0'
        ]);
        $chart->dataset('Commandes', 'line', $data1)->options([
            'fill' => 'true',
            'backgroundColor' => '#0000ff'
        ]);
        $chart->title('Demandes/Commandes Mensuelles', 20, '#0098ac', true, "'Helvetica Neue', 'Helvetica', 'Arial'");


        //Crédits chart
        $categories = Category::all();
        $data2 = array();

        $creditClient = Client::sum('credit');
        array_push($data2, $creditClient);
        $creditFournisseur = Fournisseur::sum('credit');
        array_push($data2, $creditFournisseur);

        $chart1 = new Ex1();
        $chart1->labels(['Crédits Client', 'Crédits Fournisseur']);
        $chart1->dataset('Produits', 'doughnut', $data2)->options([
            'backgroundColor' => ['#66ff66','#ff6666']
        ]);
        $chart1->title('Crédits', 20, '#0098ac', true, "'Helvetica Neue', 'Helvetica', 'Arial'");

        //Charges
        $charges = Charge::where('store_id', Auth::user()->store->id)->first();
        $salaire = Employee::where('store_id', Auth::user()->store->id)->sum('salaire');

        //Entrées et Sorties chart
        $data3 = array();
        $data4 = array();
        for($i=0; $i<12; $i++){
            $n = $i+1;
            $from = "$y-$n-01";
            $to = "$y-$n-31";
            $entree = Paiement::whereNotNull('client_id')->whereBetween('created_at', [$from, $to])->sum('montant_paye');    
            $sortie = Paiement::whereNotNull('fournisseur_id')->whereBetween('created_at', [$from, $to])->sum('montant_paye');   
            //$entree = 0;
            //$sortie = 0; 
            array_push($data3, $entree);
            array_push($data4, $sortie);
        }
        $chart2 = new Ex1();
        $chart2->labels(['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre']);
        $chart2->dataset('Entrées', 'line', $data3)->options([
            'fill' => 'true',
            'backgroundColor' => '#66ff66'
        ]);
        $chart2->dataset('Sorties', 'line', $data4)->options([
            'fill' => 'true',
            'backgroundColor' => '#ff6666'
        ]);
        $chart2->title('Entrées et sorties du magasin', 20, '#0098ac', true, "'Helvetica Neue', 'Helvetica', 'Arial'");


        return view('admin.adminHome',compact('chart', 'chart1', 'chart2', 'charges', 'salaire'));
    }
}
