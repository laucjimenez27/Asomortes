@extends('adminlte::page')
@section('title', 'COMPRA DE SERVICIOS')


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header  text-white" style="background-color:#004173">
                        Compra de Servicios
                    </div>

                    <div class="p-4">
                        <form class="row g-3 " action="{{ route('service.updateStock') }}" method="POST">
                            @csrf

                            <div class="col-6 mt-2">
                                <label for="inputEmail4" class="form-label">Servicios</label>
                                <select class="custom-select" name='servicio'>
                                    <option selected>Seleccione</option>
                                   
                                    @foreach ($services as $service)
                                        <option value="{{ $service['id'] }}">{{ $service['nombre'] }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-6 mt-2">
                                <label for="inputEmail4" class="form-label">Proveedores</label>
                                <select class="custom-select" name='proveedor'>
                                    <option selected>Seleccione</option>
                                   
                                    @foreach ($providers as $provider)
                                        <option value="{{ $provider['id'] }}">{{ $provider['razon_social'] }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-6 mt-2">
                                <label for="disabledTextInput" class="form-label">Cantidad</label>
                                <input type="number" min="1" step="1" id="disabledTextInput" class="form-control" name="cantidad">
                            </div>

                            <div class="col-6 mt-2">
                                <label for="disabledTextInput" class="form-label">Monto</label>
                                <input type="number" min="1" step="0.01" id="disabledTextInput" class="form-control" name="monto">
                            </div>

                            <div class="col-6 mt-2">
                                <label for="inputEmail4" class="form-label">Boleta/Factura</label>
                                <select class="custom-select" name='boletaFactura'>
                                    <option selected>Seleccione</option>
                                    <option value="Boleta">Boleta</option>
                                    <option value="Factura">Factura</option>
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="disabledTextInput" class="form-label">N° de comprobante</label>
                                <input type="text" id="disabledTextInput" class="form-control" name="n_comprobante">
                            </div>

                            <div class="container">
                                <div class="col-6 mt-2 justify-content-center">
                                    <label for="inputEmail4" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" name='fecha_compra' value="{{ $now->format('Y-m-d') }}">
                                </div>
                            </div>


                            <div class="col-4 container mt-5">
                                <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a href="{{ route('services.index') }}" class="btn btn-danger" onclick="return confirm('¿Desea cancelar?')">Cancelar</a>
                                        <button type="reset" class="btn btn-secondary">Limpiar formulario</button>
                                </div>
                            </div>
                            

                        </form>




                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection