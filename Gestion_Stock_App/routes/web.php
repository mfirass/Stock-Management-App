<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();
Route::group(['middleware' => ['is_admin']], function () {
    Route::get('admin/home', 'HomeController@adminHome')->name('admin.home');


    Route::get('admin/users','UtilisateurController@index')->name('admin.users');
    Route::post('admin/users','UtilisateurController@store');
    Route::get('admin/users/edit/{user}','UtilisateurController@edit')->name('user.edit');
    Route::delete('admin/users/{user}','UtilisateurController@destroy')->name('user.delete');
    Route::put('admin/users/{user}','UtilisateurController@update')->name('user.update');
    Route::get('admin/users/profil/{user}','UtilisateurController@profil')->name('admin.profil');
    Route::put('admin/users/profil/{user}','UtilisateurController@modifie')->name('admin.modifie');

    Route::get('admin/categories','CategoryController@index')->name('admin.categories');
    Route::post('admin/categories','CategoryController@store')->name('category.add');
    
    Route::get('admin/products','ProductController@index')->name('admin.produits');
    Route::post('admin/products','ProductController@store')->name('produits.add');
    Route::get('admin/products/edit/{product}','ProductController@edit')->name('product.edit');
    Route::put('admin/products/edit/{product}','ProductController@update')->name('product.update');
    Route::patch('admin/products/{product}','ProductController@replace')->name('product.replace');
    Route::patch('admin/products/{product}/diff','ProductController@replace')->name('product.diff');
    Route::delete('admin/products/{product}','ProductController@destroy')->name('product.delete');
    
    Route::get('admin/clients','ClientController@index')->name('admin.clients');
    Route::post('admin/clients','ClientController@store')->name('client.add');
    Route::put('admin/clients/{client}','ClientController@update')->name('client.update');
    Route::delete('admin/clients/{client}','ClientController@destroy')->name('client.delete');
    Route::patch('admin/clients/{client}/pdf', 'ClientController@facturePdf')->name('factureClient.pdf');

    
    Route::get('admin/fournisseurs','FournisseurController@index')->name('admin.fournisseurs');
    Route::post('admin/fournisseurs','FournisseurController@store')->name('fournisseur.add');
    Route::put('admin/fournisseurs/{fournisseur}','FournisseurController@update')->name('fournisseur.update');
    Route::delete('admin/fournisseurs/{fournisseur}','FournisseurController@destroy')->name('fournisseur.delete');
    
    Route::get('admin/demandes','DemandeController@index')->name('admin.demandes');
    Route::get('admin/demandes/create','DemandeController@create')->name('demande.create');
    Route::get('admin/demandes/create/prix/{client}/{produit}','DemandeController@prix');
    Route::post('admin/demandes','DemandeController@store')->name('demande.add');
    Route::get('admin/demandes/fin','DemandeController@fin')->name('demande.fin');
    Route::post('admin/demandes/{demande}','DemandeController@addProduct')->name('demande.addProduct');
    Route::delete('admin/demandes/{demande}/delete','DemandeController@destroy')->name('demande.delete');
    Route::patch('admin/demandes/{demande}/verifie','DemandeController@verifie')->name('demande.verifie');
    Route::patch('admin/demandes/{demande}/pay','DemandeController@pay')->name('demande.pay');
    Route::get('admin/demandes/{demande}','DemandeController@edit')->name('demande.update');
    Route::get('admin/demandes/{demande}/pdf', 'DemandeController@demandePdf')->name('demande.pdf');
    
    Route::get('admin/commandes','CommandeController@index')->name('admin.commandes');
    Route::get('admin/commandes/create','CommandeController@create')->name('commande.create');
    Route::post('admin/commandes','CommandeController@store')->name('commande.add');
    Route::get('admin/commandes/fin','CommandeController@fin')->name('commande.fin');
    Route::post('admin/commandes/{commande}','CommandeController@addProduct')->name('commande.addProduct');
    Route::delete('admin/commandes/{commande}/delete','CommandeController@destroy')->name('commande.delete');
    Route::patch('admin/commandes/{commande}/verifie','CommandeController@verifie')->name('commande.verifie');
    Route::patch('admin/commandes/{commande}/pay','CommandeController@pay')->name('commande.pay');
    Route::get('admin/commandes/{commande}','CommandeController@edit')->name('commande.update');
    Route::get('admin/commandes/{commande}/pdf', 'CommandeController@demandePdf')->name('commande.pdf');
    
    Route::get('admin/employees','EmployeeController@index')->name('admin.employees');
    Route::post('admin/employees', 'EmployeeController@store')->name('employee.add');
    Route::put('admin/employees/{employee}','EmployeeController@update')->name('employee.update');
    Route::delete('admin/employees/{employee}','EmployeeController@destroy')->name('employee.delete');
    
    Route::get('admin/charges','ChargeController@index')->name('charges');
    Route::put('admin/charges/{charge}','ChargeController@update')->name('charge.update');
});

 




Route::get('home', 'HomeController@index')->name('user.home');

Route::get('users/profil/{user}','UtilisateurController@profil')->name('user.profil');
Route::put('users/profil/{user}','UtilisateurController@modifie')->name('user.modifie');

Route::post('categories','CategoryController@store')->name('category.add1');

Route::get('products','ProductController@index')->name('user.produits');
Route::post('products','ProductController@store')->name('produits.add1');
Route::get('products/edit/{product}','ProductController@edit')->name('product.edit1');
Route::put('products/edit/{product}','ProductController@update')->name('product.update1');
Route::put('products/{product}','ProductController@replace')->name('product.diff1');
Route::delete('products/{product}','ProductController@destroy')->name('product.delete1');

Route::get('clients','ClientController@index')->name('user.clients');
Route::post('clients','ClientController@store')->name('client.add1');
Route::put('clients/{client}','ClientController@update')->name('client.update1');
Route::delete('clients/{client}','ClientController@destroy')->name('client.delete1');

Route::get('fournisseurs','FournisseurController@index')->name('user.fournisseurs');
Route::post('fournisseurs','FournisseurController@store')->name('fournisseur.add1');
Route::put('fournisseurs/{fournisseur}','FournisseurController@update')->name('fournisseur.update1');
Route::delete('fournisseurs/{fournisseur}','FournisseurController@destroy')->name('fournisseur.delete1');

Route::get('demandes','DemandeController@index')->name('user.demandes');
Route::put('demandes/{demande}/verifie','DemandeController@verifie1')->name('demande.verifie1');

Route::get('commandes','CommandeController@index')->name('user.commandes');

Route::get('employees','EmployeeController@index')->name('user.employees');
Route::post('admin/employees','EmployeeController@store')->name('employee.add1');
Route::put('admin/employees/{employee}','EmployeeController@update')->name('employee.update1');
Route::delete('admin/employees/{employee}','EmployeeController@destroy')->name('employee.delete1');

Route::put('charges/{charge}','ChargeController@update')->name('charge.update');




Route::get('/prix/{client}/{produit}','AjaxController@prix');
Route::get('/prix-a/{fournisseur}/{produit}','AjaxController@prix_achat');
Route::get('/type/{client}','AjaxController@type');