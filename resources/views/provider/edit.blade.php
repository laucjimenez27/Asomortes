@extends('adminlte::page')
@section('title', 'PROVEEDORES')


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white" style="background-color:#004173">
                        Actualizar Proveedor
                    </div>

                    <div class="p-4">
                        <form class="row g-3 " action="{{route('provider.update',$provider->id)}}" method="POST">
                            @csrf


                            <div class="col-12 ">
                                <label for="disabledTextInput" class="form-label">Razon Social</label>
                                <input type="text" id="disabledTextInput" class="form-control" name="razon_social"
                                value='{{$provider->razon_social}}'>

                            </div>

                            <div class="col-6 mt-2">
                                <label for="disabledTextInput" class="form-label">Ruc</label>
                                <input type="number" min="1" step="0.01" id="disabledTextInput" class="form-control" name="ruc"
                                value='{{$provider->ruc}}'>
                            </div>


                            <div class="col-6 mt-2">
                                <label for="disabledTextInput" class="form-label">Dirección</label>
                                <input type="text" id="disabledTextInput" class="form-control" name="direccion"
                                value='{{$provider->direccion}}'>

                            </div>

                            <div class="col-6 mt-2">
                                <label for="disabledTextInput" class="form-label">Telefono</label>
                                <input type="number" min="1" step="0.01" id="disabledTextInput" class="form-control" name="telefono"
                                value='{{$provider->telefono}}'>
                            </div>

                            <div class="col-6 mt-2">
                                <label for="disabledTextInput" class="form-label">Email</label>
                                <input type="text" id="disabledTextInput" class="form-control" name="email"
                                value='{{$provider->email}}'>
                            </div>

           
                            <div class="col-3 container mt-5">
                                <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a href="{{ route('providers.index') }}" class="btn btn-danger" onclick="return confirm('¿Desea cancelar el proceso de actualización?')">Cancelar</a>
                                </div>
                            </div>

                        </form>




                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection