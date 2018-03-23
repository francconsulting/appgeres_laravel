@extends('layouts.app')


@section('htmlheader_title')
    geres
@endsection



@section('contentheader_title')
    "en el header" {{--$tituloModulo--}}
    {{--$aSanitarios--}}

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
            <h3 class="box-title">Lista Personal Sanitario</h3>
        </div>
        <div class="box-body">
            <table id="listaUsuario" class="table table-bordered table-striped dataTable" cellpadding="3" cellspacing="2">
                <thead>
                <tr>
                    <th>nº</th>
                    <th></th>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Rol</th>
                    <th></th>
                </tr>
                {{csrf_field()}}
                </thead>
                <tbody>
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
@stop


