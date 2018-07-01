@extends('layouts.app')

@section('htmlheader_title')
    - {{$modulo}}
@endsection

@section('contentheader_title')
    {{ $modulo }}
@endsection

@section('main-content')

    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="text-left">
                <button type='button' id="addUser" class='ver btn bg-olive right'><i
                            class='glyphicon glyphicon-user'></i> Agregar nuevo
                </button>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Lista Personal {{ substr($modulo,0, strlen($modulo)-1) }}</h3>
        </div>
        <div class="box-body">
            <table id="listaUsuario" class="table table-bordered table-striped dataTable" cellpadding="3" cellspacing="2">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th></th>
                </tr>
                {{csrf_field()}}
                </thead>
                <tbody>
                <!-- carga de los datos con el plugin DataTables,
                    no usamos este foreach de Blade
                 -->
               {{-- @foreach($sanitarios as $item)    --}}
                    <tr class="item{{--$item->id--}}">
                        <td></td>
                        <td>{{--$item->id--}}</td>
                        <td>{{--$item->sNombre--}}</td>
                        <td>{{--$item->sApellidos--}}</td>
                        <td>{{--$item->sDni--}}</td>
                    </tr>
              {{--  @endforeach  --}}
                </tbody>
            </table>

        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="text-right">
                <button type='button' id="idRecarga" class='ver btn btn-primary'><i class='glyphicon glyphicon-repeat'></i>
                    Recargar
                </button>
            </div>
        </div>
    </div>
    @include('layouts.modal')
@endsection

@section('scripts-modulo')
    @include('sanitarios.partials.scripts')
@stop


