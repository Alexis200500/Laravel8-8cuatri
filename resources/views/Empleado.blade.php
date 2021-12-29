<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{asset('css/estilos.css')}}">
</head>
<body>
    <h1>EMPRESA ALEXIS</h1>
    <br>
    Nombre del empleado {{$nombre}} trabajo {{$dias}} y se le pago {{$nomina}}
    @if($nombre=="Strange")
        <h1>HOLA STRANGE</h1>
        <img src="{{asset('fotos/strange.jpg')}}" height=100 witdh=100>
        
    @endif
    @if($nombre=="Peter")
        <h1>HOLA Peter</h1>
        <img src="{{asset('fotos/1.jpg')}}" height=100 witdh=100>
    @else
        <h1>Sin Foto</h1>    
    @endif
    <a href="{{route('salir')}}">Cerrar Nomina</a>
</body>
</html>