<?php

namespace App\Http\Controllers;

use App\User;
use App\Store;
use App\Charge;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;
use UxWeb\SweetAlert\SweetAlert;
use Illuminate\Support\Facades\Auth;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users= DB::table('users')->get();
        return view('admin.user', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        $customMessages = [
            'required' => 'Champ :attribute ne peut pas être vide.',
            'unique' => ':attribute existe déja.',
            'same' => 'Mot de passe doit être confirmé correctement.',            
        ];
        
        request() -> validate([
            'name' => ['required' , 'string','min:3' , 'max:40' ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['nullable', 'numeric', 'digits:10','phone_number'],
            'password' => ['required_with:password_confirmation', 'string', 'min:8', 'same:password_confirmation'],
            'password_confirmation' => 'min:8',
            'is_admin' => 'nullable' ,
        ], $customMessages);

        $user = new User() ;
        $user -> name = request('name') ;
        $user -> email = request('email') ;
        $user -> telephone = request('telephone') ;
        $user -> is_admin = request('is_admin') ;
        $user -> password = Hash::make(request('password')) ;
        $user -> save() ;
        $store = new Store();
        $store -> user_id = $user -> id ;
        $store -> save() ;
        $charge = new Charge();
        $charge -> store_id = $store -> id;
        $charge ->save();
        return redirect()->route('admin.users')->with('success','Utilisateur a été ajouté avec succès.');
    }





    /**
     * Display the specified resource.
     *
     * @param  \App\utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        return view('admin.userEdit',[ 'user' => $user ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        //
        $customMessages = [
            'required' => 'Champ :attribute ne peut pas être vide .',
            'unique' => ':attribute existe déja.',
            'phone_number' => 'Le numéro de telephone doit être valide.',            
        ];
        $validator = request() -> validate([
            'name' => ['required' , 'string','min:4' , 'max:40' ],
            'email' => ['required', 'string', 'email', 'max:255', ''],
            'telephone' => ['nullable', 'numeric', 'digits:10','phone_number'],
            'is_admin' => 'nullable' ,
        ],$customMessages);


        $user -> name = request('name');
        $user -> email = request('email');
        $user -> telephone = request('telephone');
        $user -> is_admin = request('is_admin');
        $user -> save();      

        return redirect()->route('admin.users')->with('success',"Profile de l'utilisateur modifié avec succès.");
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user -> delete();
        return back()->with('success','Utilisateur supprimé avec succès.');
        
    }

    public function profil(User $user, Request $request){
        if($request->is('admin*')){
            return view('admin.profil', compact('user'));
        }
        return view('userProfile', compact('user'));
    }

    public function modifie(User $user, Request $request){
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return back()->with("error","Votre mot de passe actuel ne correspond pas au mot de passe que vous avez fourni. S’ll vous plaît, réessayez.");
        }
        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return back()->with("error","Nouveau mot de passe ne peut pas être le même que votre mot de passe actuel. S’il vous plaît choisir un mot de passe différent.");
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'nullable|string|min:8|same:password_confirm',
            'password_confirm'=>'nullable',
        ],[
            'same'=>'Le nouveau mot de passe doit être confirmé correctement.',
            'required'=>'Champ mot de passe ne peut pas être vide.',
        ]);
        if(!is_null($request->get('new_password'))){
        $user->password = bcrypt($request->get('new_password'));
        $user->save();  
        }
        $user->telephone = request('telephone');
        $user->save();
        $user->update([
            'name'=>request('name'), 'email'=>request('email'),
        ]);

        return back()->with("success","Profile modifié avec succès");
    }
}