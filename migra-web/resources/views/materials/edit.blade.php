@extends('adminlte::page')

@section('title')
    @lang('messages.edit_material')
@stop

@section('content')
    <div class="box box-primary">
        <form method="POST" action="{{route('materials.update',$material)}}">
            @csrf
            @method('PATCH')
            <div class="box-header with-border">
                <h3 class="box-title">@lang('messages.edit_material')</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.name')</label>
                        <input required type="text" class="form-control" name="name" value="{{$material->name}}" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.description')</label>    
                        <textarea required type="text" class="form-control" value="{{$material->description}}" name="description">{{$material->description}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>@lang('messages.density')</label>
                        <input id="density" type="text" class="form-control" value="{{$material->density}}" name="density">
                        <label id="message" style="color:red"></label>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class='btn btn-primary' data-toggle='modal' data-target='#modalUpdate' data-link="{{route('materials.update', $material)}}" data-name='{{$material->name}}'>@lang('messages.save')</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    document.getElementById('density').addEventListener("focusin", function(){
        document.getElementById('message').innerHTML = "Alterar a densidade irá mudar os registros existentes.";
    });
    document.getElementById('density').addEventListener("focusout",function() {
        document.getElementById('message').innerHTML = "";
    });

    </script>
@stop
