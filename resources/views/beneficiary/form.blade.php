@extends('adminlte::page')
@section('title', 'BENEFICIARIOS')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection
<style>
    label.error {
        color: red;
        font-size: 0.8em;
    }
</style>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white" style="background-color:#004173">
                        Registrar Nuevo Beneficiario

                        <div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }} <br>
                            @endforeach
                        </div>
                    @endif
                    <div class="p-4">
                        <form class="row g-3 " action="{{ route('beneficiaries.store') }}" method="POST"
                            id="form_beneficiarios">
                            @csrf

                            <div class="col-6 ">
                                <input type="hidden" class="form-control" name='id_partner' value="{{ $partner->id }}">
                            </div>
                            <div class="col-12 mt-5">
                                <label for="" class="form-label">Nombre Socio:</label>
                                <input type="text" class="form-control" name='nombre_partner'
                                    value="{{ $partner->nombre . ' ' . $partner->apellido_paterno . ' ' . $partner->apellido_materno }}"
                                    disabled>
                            </div>

                            <div class="col-12 mt-5">
                                <label for="" class="form-label">Nombres y Apellidos</label>
                                <input type="text" class="form-control" name='nombres_apellidos'
                                    value="{{ old('apellido_paterno') }}">
                            </div>


                            <div class="col-6 mt-2">
                                <label for="" class="form-label">Dni</label>
                                <input type="text" class="form-control" name='dni' value="{{ old('dni') }} ">
                            </div>

                            <div class="col-6 mt-2">
                                <label for="" class="form-label">Celular</label>
                                <input type="text" class="form-control" name='celular' value="{{ old('celular') }} ">
                            </div>

                            <div class="col-6 mt-2">
                                <label for="" class="form-label">Email</label>
                                <input type="email" class="form-control" name='email' value="{{ old('email') }} ">
                            </div>

                            <div class="col-6 mt-2">
                                <label for="" class="form-label">Parentesco:</label>
                                <select class="custom-select" name='parentesco'>
                                    <option selected>Seleccione</option>
                                    <option value="hijo">Hijo</option>
                                    <option value="hermano">Hermano</option>
                                    <option value="esposo">Esposo</option>
                                    <option value="primo">Primo</option>
                                </select>
                            </div>

                            <div class="col-6 mt-2">
                                <label for="" class="form-label">Fecha de ingreso: </label>
                                <input type="date" class="form-control" name='fecha_de_ingreso'
                                    value="{{ $now->format('Y-m-d') }}">
                            </div>


                            <div class="col-12 mt-4 ">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="" class="btn btn-danger">Cancelar </a>
                                <a href="" class="btn btn-secondary">Limpiar Formulario </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $.validator.addMethod("soloLetras", function(value, element) {
                var pattern = /^[a-zA-ZÀ-ÿ\s]{1,50}$/;
                return this.optional(element) || pattern.test(value);
            }, "El campo no acepta números o signos");

            $.validator.addMethod("soloNumeros", function(value, element) {
                var pattern = /^([0-9]{9,9})$/;
                return this.optional(element) || pattern.test(value);
            }, "Ingrese un número válido de 9 dígitos");

            $.validator.addMethod("dniValidar", function(value, element) {
                var pattern = /^([0-9]{1,8})$/;
                return this.optional(element) || pattern.test(value);
            }, "Ingrese un número de DNI válido");

            $.validator.addMethod("carneValidar", function(value, element) {
                var pattern = /^([0-9]{1,5})$/;
                return this.optional(element) || pattern.test(value);
            }, "Ingrese un número de carné válido");

            $.validator.addMethod("numerosLetras", function(value, element) {
                var pattern = /^[a-zA-Z0-9\_\-]{1,50}$/;
                return this.optional(element) || pattern.test(value);
            }, "No puede ingresar signos");

            $("#form_beneficiarios").validate({
                rules: {
                    nombres_apellidos: {
                        required: true,
                        soloLetras: true
                    },
                    
                    dni: {
                        required: true,
                        dniValidar: true
                    },
                    celular: {
                        required: true,
                        soloNumeros: true
                    }, 
                    email: {
                        required: true,
                        email: true
                    },
                    
                    fecha_de_ingreso: {
                        required: true
                    },
                    parentesco: {
                        required: true 
                    }
                    


                },
                messages: {
                    nombres_apellidos: {
                        required: "El campo nombre es obligatorio",
                    },
                    
                    dni: {
                        required: "El campo DNI es obligatorio"
                    },
                    celular: {
                        required: "El campo celular es obligatorio"
                    },
                   
                    email: {
                        required: "El campo email es obligatorio",
                        email: "El fomato no es válido"
                    },
                    
                    fecha_de_ingreso: {
                        required: "El campo fecha de ingrese es obligatorio"
                    },
                    parentesco: {
                        required: "El campo fecha de nacimiento es obligatorio"
                    }



                }
            });
        });
    </script>
@endsection
@endsection
