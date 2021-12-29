<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\empleados;
use App\Models\departamentos;
use App\Models\nominas;
use Session;

class EmpleadosController extends Controller
{
    public function modificaempleado($ide){
        $consulta = empleados::withTrashed()->join('departamentos','empleados.idd','=','departamentos.idd')
        ->select('empleados.ide','empleados.nombre','empleados.apellido','empleados.sexo','empleados.celular',
                 'departamentos.nombre as depa','empleados.email','empleados.idd','empleados.descripcion','empleados.img')
        ->where('ide',$ide)
        ->get();
        // return $consulta;
        $departamentos = departamentos::all();

        return view('modificaempleado')
            ->with('consulta',$consulta[0])
            ->with('departamentos',$departamentos);
    }
    public function guardacambios(Request $request){
        $this->validate($request,[
            'nombre'=> 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
            'apellido'=> 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
            'email'=> 'required|email',
            'celular'=> 'required|regex:/^[0-9]{10}$/',
            'img'=>'image|mimes:gif,jpeg,png'
        ]);

        $file = $request->file('img');
        if($file<>""){
        $img = $file->getClientOriginalName();
        $img2 = $request->ide . $img;
        \Storage::disk('local')->put($img2, \File::get($file));
        }
        // dd($request);

        $empleados = empleados::withTrashed()->find($request->ide);
        $empleados->ide = $request->ide;
        $empleados->nombre = $request->nombre;
        $empleados->apellido = $request->apellido;
        $empleados->email = $request->email;
        $empleados->celular = $request->celular;
        $empleados->sexo = $request->sexo;
        $empleados->descripcion = $request->descripcion;
        $empleados->idd = $request->idd;
        if($file<>""){
        $empleados->img = $img2;
      }
        $empleados->save();

        Session::flash('mensaje',"El empleado $request->nombre $request->apellido ha sido modificado");

        return redirect()->route('reporteempleados');
    }
    public function borrarempleado($ide){
        $buscaempleado = nominas::where('ide',$ide)->get();
        $cuantos = count($buscaempleado);
        if($cuantos==0)
        {
            $empleados=empleados::withTrashed()->find($ide)->forceDelete();
            Session::flash('mensaje',"El empleado ha sido
                            borrado del sistema correctamente");

            return redirect()->route('reporteempleados');
        }
        else{

            Session::flash('mensaje',"El empleado no se puede borrar del sistema porque
                            tiene registro de nominas");

            return redirect()->route('reporteempleados');

        }
    }
    public function activarempleado($ide){
        $empleados=empleados::withTrashed()->where('ide',$ide)->restore();

        Session::flash('mensaje',"El empleado ha sido activado correctamente");

        return redirect()->route('reporteempleados');
    }
    public function desactivaempleado($ide){
        $empleados=empleados::find($ide);
        $empleados->delete();

        Session::flash('mensaje',"El empleado ha sido desactivado correctamente");

        return redirect()->route('reporteempleados');
    }
    public function reporteempleados(){
        $sessionidu = session('sessionidu');
        $sessiontipo = session('sessiontipo');
       
        if ($sessionidu<>"" and $sessiontipo<>"") {
        $consulta = empleados::withTrashed()->join('departamentos','empleados.idd','=','departamentos.idd')
        ->select('empleados.ide','empleados.nombre','empleados.apellido','departamentos.nombre as depa',
                 'empleados.email','empleados.deleted_at','empleados.img')
        ->orderBy('empleados.apellido')
        ->orderBy('empleados.nombre')
        ->get();
        return view('reporteempleados')
                ->with('consulta',$consulta)
                ->with('sessiontipo',$sessiontipo);

        
        }else{
            Session::flash('mensaje','Loguearse antes de continuar');
            return redirect()->route('login');
        }
    }

    public function altaempleado(){
        $consulta = empleados::orderBy('ide','DESC')
            ->take(1)->get();

        $cuantos = count($consulta);
        if ($cuantos==0) {
            $idesigue = 1;
        } else {
            $idesigue = $consulta[0]->ide + 1;
        }

        $departamentos = departamentos::orderBy('nombre')->get();

        // return $idesigue;
        return view('altaempleado')
                ->with('idesigue',$idesigue)
                ->with('departamentos',$departamentos);
    }

    public function guardarempleado(Request $request){
        //return $request;
        $this->validate($request,[
            'nombre'=> 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
            'apellido'=> 'required|regex:/^[A-Z][A-Z,a-z, ,á,é,í,ó,ú,ü]+$/',
            'email'=> 'required|email',
            'celular'=> 'required|regex:/^[0-9]{10}$/',
            'img'=>'image|mimes:gif,jpeg,png'
        ]);

        $file = $request->file('img');
        if($file<>""){
        $img = $file->getClientOriginalName();
        $img2 = $request->ide . $img;
        \Storage::disk('local')->put($img2, \File::get($file));
        }
        else{
            $img2 = "sinfoto.png";
        }
        $empleados = new empleados;
        $empleados->ide = $request->ide;
        $empleados->nombre = $request->nombre;
        $empleados->apellido = $request->apellido;
        $empleados->email = $request->email;
        $empleados->celular = $request->celular;
        $empleados->sexo = $request->sexo;
        $empleados->descripcion = $request->descripcion;
        $empleados->idd = $request->idd;
        $empleados->img = $img2;

        $empleados->save();

        /*return view('mensajes')
            ->with('proceso','ALTA DE EMPLEADO')
            ->with('mensaje',"El empleado $request->nombre $request->apellido ha sido dado de alta correctamente")
            ->with('error',1);*/

            Session::flash('mensaje',"El empleado $request->nombre $request->apellido ha sido dado
                                    de alta correctamente");

            return redirect()->route('reporteempleados');


        // if ($sexo=='M') {
        //     echo "El empleado $nombre es de sexo Maculino ";
        // } else {
        //     echo "El empleado $nombre es de sexo Femenino ";
        // }


        // dd($request);
        // return view('guardarempleado');
    }

    public function eloquent(){
        // $consulta = empleados::all();

        // $empleados = new empleados;
        // $empleados->ide = 2;
        // $empleados->nombre = "Erik";
        // $empleados->apellido = "Morales";
        // $empleados->email = "Erik@gmail.com";
        // $empleados->celular = "7224928104";
        // $empleados->sexo = "M";
        // $empleados->descripcion = "DESC2";
        // $empleados->idd = 2;
        // $empleados->save();

        // $empleados= empleados::create([
        //     'ide'=>10,
        //     'nombre'=>'Erik','apellido'=>'Morales','email'=>'erik@gmail.com',
        //     'celular'=>'7293240921','sexo'=>'M','descripcion'=>'DEs 3','idd'=>'1']);

        // $empleados= empleados::create([
        //     'ide'=>11,
        //     'nombre'=>'Alexis','apellido'=>'Morales','email'=>'alex@gmail.com',
        //     'celular'=>'7293240921','sexo'=>'M','descripcion'=>'DEs 3','idd'=>'1']);


        // $empleados= empleados::find(1);
        // $empleados-> nombre="Roman";
        // $empleados-> apellido="Morales";
        // $empleados->save();

        // empleados::where('sexo','M')
        //             ->where('email','al@gmail.com')
        //             ->update(['nombre'=>'Francisco','celular'=>'7228032683']);

        // empleados::destroy(1);

        // $empleados=empleados::find(1);
        // $empleados->delete();

        // $consulta = empleados::withTrashed()->get();  //mostrar todos los registros  con borrados
        // return $consulta;

        // $consulta = empleados::onlyTrashed()->get();    //mostrar solo registros borrados
        // return $consulta;

        // $consulta = empleados::onlyTrashed()
        //             ->where('sexo','M')
                    //    ->get();

        // empleados::withTrashed()->where('ide',1)->restore();

        // $empleados=empleados::find(1)->forceDelete();
        // $consulta = empleados::all();
        // return "restauracion realizada";




        $consulta = empleados::all();

        $consulta = empleados::where('sexo','M')->get();


        $consulta = empleados::where('edad','>=',22)
                               ->where('edad','<=',30)
                               ->get();

        $consulta = empleados::whereBetween('edad',[20,23])->get();

        $consulta = empleados::whereIn('ide',[2,3,4])
                               ->orderBy('nombre','asc')
                               ->get();

        $consulta = empleados::where('edad','>=',22)
                               ->where('edad','<=',30)
                               ->take(2)
                               ->get();

        $consulta = empleados::select(['nombre','apellido','edad'])
                                ->where('edad','>=','25')
                                ->get();


        $consulta = empleados::select(['nombre','apellido','edad'])
                                ->where('nombre','LIKE','%na%')
                                ->get();

        $consulta = empleados::where('sexo','F')->sum('salario');

        $consulta = empleados::groupBY('sexo')
                                ->selectRaw('sexo,sum(salario) as salariototal')
                                ->get();

        $consulta = empleados::groupBY('sexo')
                                ->selectRaw('sexo,count(*) as cuantos')
                                ->get();

        /*SQL = "SELECT e.ide, e.nombre, e.nombre AS departamentos, e.edad
        FROM empleados AS e
        INNER JOIN departamentos AS d ON d.idd = e.idd
        WHERE e.edad>=25"  */


        $consulta = empleados::join('departamentos','empleados.idd','=','departamentos.idd')
        ->select('empleados.ide','empleados.nombre','departamentos.nombre as depa','empleados.edad')
        ->where('empleados.edad','>=',25)
        ->get();

        $consulta = empleados::where('edad','>=',25)
        ->orwhere('sexo','F')
        ->get();

        // $cuantos = count($consulta);
        return $consulta;


    }

    public function vb(){
        return view('vistabootstrap');
    }

    public function saludo($nombre,$dias){
        $pago=100;
        $nomina = $dias*$pago;

        // return view('Empleado',compact('nombre','dias'));
        // return view('Empleado',['nombre'=>$nombre,'dias'=>$dias]);
        return view('Empleado')
            ->with('nombre',$nombre)
            ->with('dias',$dias)
            ->with('nomina',$nomina);
    }
    public function salir(){
        return 'Salir';
    }

    public function mensaje(){
        return "Hola trabajador";
    }

    public function pago(){
        $dias=6;
        $pago=600;
        $nomina = $dias * $pago;
        return "El pago de la nomina es: $nomina";
    }

    public function nomina($diast,$pago){
        $nomina = $diast*$pago;
        dd($nomina, $diast,$pago); //depurar codigo y ver si esta viajando la variable
        return "El pago de la nomina es $nomina con dias trabajados $diast y pago diario $pago";
    }
}
