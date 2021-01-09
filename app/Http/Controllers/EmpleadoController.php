<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
//para borrar en el storage
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Muestra todos los emplados paginados de 5 en 5

        // Pasando datos con compact
        // $empleados = Empleado::paginate(5);
        // return view('empleado.index', compact('empleados'));

        $datos['empleados'] = Empleado::paginate(5);
        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Validar los campos
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
            'Foto' => 'required|max:10000|mimes:jpeg, png, jpg'
        ];
        $mensaje=[
            'required'=>'El :attribute es requerido',
            'Foto.required'=>'La Foto es requerida',
            'Correo.email' => 'Correo no valido'
        ];

        $this->validate($request, $campos, $mensaje);
        //Guardar los nuevos datos

        //una forma de gurdar, nececitas los filables
        // $dataLimpia = request()->except('_token');
        // $datosEmpleado = new Empleado($dataLimpia);
        // $datosEmpleado->save();
        //Otra forma de guardar no se ocupan los filables 
        // $datosEmpleado = request()->except('_token');
        // Empleado::insert($datosEmpleado);
        //otra forma con create
        $datosLimpios = request()->except('_token');
        if($request->hasFile('Foto')){
            $datosLimpios['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }
        $datosEmpleado = Empleado::create($datosLimpios);

        return redirect('empleado')->with('mensaje', 'Empleado agregado con EXITO');
        // return response()->json($datosEmpleado, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Edita los datos guardados
        $empleado = Empleado::findOrFail($id);

        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
        ];
        $mensaje=[
            'required'=>'El :attribute es requerido',
        ];
        if($request->hasFile('Foto')){
            $campos=[
            'Foto' => 'required|max:10000|mimes:jpeg, png, jpg'
            ];
            $mensaje=[
            'Foto.required'=>'La Foto es requerida'

            ];
        }
        $this->validate($request, $campos, $mensaje);

        //Esta seria una forma
        // $datosLimpios = request()->except(['_token', '_method']);

        // $datosEmpleado = Empleado::find($id);
        // $datosEmpleado->update($datosLimpios); 
        $datosEmpleado = request()->except(['_token', '_method']);

        if($request->hasFile('Foto')){
            $empleado = Empleado::find($id);
            Storage::delete('public/'.$empleado->Foto);

            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        Empleado::where('id','=', $id)->update($datosEmpleado);
        $empleado = Empleado::find($id);
        // return view('empleado.edit', compact('empleado'));

        return redirect('empleado')->with('mensaje', 'Editado');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Borrar el empleado
        $empleado = Empleado::find($id);

        Storage::delete('public/'.$empleado->Foto);
        Empleado::destroy($id);

        return redirect('empleado')->with('mensaje', 'Borrado');

    }
}
