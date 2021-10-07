<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $stores = Store::all();
        $employees = Auth::user()->store->employees;
        if($request->is('admin*')){
            $employees = Employee::orderBy('store_id')->paginate();
            return view('admin.employee',[
                'employees'=>$employees, 'stores'=>$stores,
            ]);
        }
        return view('employee',[
            'employees'=>$employees,
        ]);

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

        request() -> validate([
            'store'=>'required',
            'name' => ['required', 'string', 'max:40' ],
            'email' => ['required', 'string', 'email', 'max:255'],
            'telephone' => ['nullable', 'numeric', 'digits:10','phone_number'],
            'salaire'=>'required'
        ],[
            'required'=>'Ce champ ne doit pas etre vide',
            'max'=>'Maximum :max caractères'
        ]);

        $employee = new Employee() ;
        $employee -> store_id = request('store');
        $employee -> nom = request('name') ;
        $employee -> email = request('email') ;
        $employee -> telephone = request('telephone') ;
        $employee -> salaire = request('salaire') ;
        $employee -> save() ;

        return back()->with("success", "Employé a été ajouté avec succès");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
        request() -> validate([
            'name' => ['required' , 'string', 'max:40' ],
            'email' => ['required', 'string', 'email', 'max:255'],
            'telephone' => ['nullable', 'numeric', 'digits:10','phone_number'],
            'salaire'=>'required'
        ],[
            'required'=>'Ce champ ne doit pas etre vide',
            'max'=>'Maximum :max caractères'
        ]);

        $employee->update([
            'nom'=>request('name'), 'email'=>request('email'), 'telephone'=>request('telephone'),
            'salaire'=>request('salaire'),
        ]);
        
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
        $employee->delete();
        return back();
    }
}
