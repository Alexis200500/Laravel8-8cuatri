@extends('vistabootstrap')

@section('contenido')

<div class="container">
    <h1>Inicio de sesion</h1>
    <hr>
    <form action="{{route('validar')}}" method="POST">
        {{csrf_field()}}
        <div class="well">
            <div class="form-group">
                <label for="dni">Usuario:
                    @if($errors->first('usuario'))
                    <p class="text-danger"> {{$errors->first('usuario')}} </p>
                    @endif
                </label>
                <input type="text" name="usuario" id="usuario" class="form-control" tabindex="5">
            </div>

            <div class="form-group">
                <label for="dni">Password:
                    @if($errors->first('pasw'))
                    <p class="text-danger"> {{$errors->first('pasw')}} </p>
                    @endif
                </label>
                <input type="password" name="pasw" id="pasw" class="form-control" tabindex="5">
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6"><input type="submit" value="Guardar"
                        class="btn btn-danger btn-block btn-lg" tabindex="7" title="Guardar datos ingresados"></div>
            </div>
        </div>
    </form>
    <br><br>
    @if(Session::has('mensaje'))
    <div class="alert alert-danger">{{Session::get('mensaje')}}</div>
    @endif
    @stop
