<?php

namespace App\Http\Controllers;

use App\Models\empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;


class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $listado['empleados'] = empleado::paginate(1);
        return view('empleados.index', $listado);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //acceder a create.blade de la vista para crear los empleados
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //validacion d elos campos al crear un registro
        $validacion = [
            'Nombres' => 'required|string|max:90',
            'PrimerApel' => 'required|string|max:90',
            'SegundoApel' => 'required|string|max:90',
            'Correo' => 'required|email|max:255',
            'Foto' => 'required|image|max:2048',
        ];

        // Mensajes de error personalizados
        $msj = [
            'required' => 'El :attribute es requerido',
            'PrimerApel.required' => 'El Primer Apellido es requerido',
            'SegundoApel.required' => 'El Segundo Apellido es requerido',
            'Correo.required' => 'El Correo es requerido',
            'Correo.email' => 'El Correo debe ser una dirección de correo electrónico válida',
            'Foto.required' => 'La Foto es requerida',
        ];

        $this->validate($request, $validacion, $msj);

        //$datosEmpleado = request()->all();
        $datosEmpleado = request()->except('_token');
        if ($request->hasFile('Foto')) {
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }
        empleado::insert($datosEmpleado);
        //return response()->json($datosEmpleado);
        return redirect('empleados')->with('mensaje','Registro ingresado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $empleado = empleado::findOrFail($id);
        return view('empleados.update', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        // $validacion = [
        //     'Nombres' => 'require|string|max:90',
        // ];
        // $msj = ['required' => 'El : attribute es requerido'];

        // if ($request ->hasFile('Foto')){
        //     $validacion = ['Foto' => 'require|string|max:10000|mines:jpg,png,jpeg'];
        //     $msj = ['Foto.required' => 'La Foto es requerido'];
        // }
        // $this-> validate($request, $validacion, $msj);
        $datos = request()->except('_token', '_method');

        //verificar si el usuario ha seleccionado una nueva foto, en caso verdadero la carag
        if($request->hasFile('Foto')){
            $datos['Foto'] = $request->File('Foto')->store('uploads','public');
        }
        //sino selecciono una nueva foto sigue con la que ya tenia anteriormente
        empleado::where('id', '=', $id)->update($datos);
        $empleado = empleado::findOrFail($id);
        return view('empleados.update', compact('empleado'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //busca la imagen que viene del id seleccionado y si la encuentra la borra
        $empleado = empleado::findOrFail($id);
        if(Storage::delete('public/'.$empleado->Foto)){
        empleado::destroy($id);
        }
        return redirect('empleados')->with('mensaje', 'Registro eliminado exitosamente');
    }
}
