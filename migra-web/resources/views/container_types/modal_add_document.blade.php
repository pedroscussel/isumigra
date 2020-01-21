<div class="modal fade modal-default " tabindex="-1" role="dialog" id='modalAddDocument'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">@lang('messages.add_document')</h4>
            </div>
            {{ Form::open(['method' => 'post', 'enctype'=>"multipart/form-data", 'id' => 'upload-form',
                'style'=>'display:inline', 'class'=>'modal-form']) }}
            <div class="modal-body">

                <div class="form-group-sm">
                    <label for="name">@lang('messages.name')</label>
                    <input type="text" value=""class="form-control" id="name" required="true"
                    placeholder="{{__('messages.name')}}" name="name">
                </div>

                <div class="form-group-sm">
                    <label for="description">@lang('messages.description')</label>
                    <textarea name='description' class='form-control'></textarea>
                </div>

                <div class="form-group">
                    <label>@lang('messages.document')</label>
                    <input type="file" class="form-control" id="document" required="true"
                    placeholder="{{__('messages.document')}}" name="document">
                </div>

                <div class="form-group-sm">
                    <p>@lang('messages.max_filesize'): <b>{{ \App\Document::getmaxUploadSizeInHuman() }}</b></p>
                    <!-- os dados abaixo ficam escondidos e servem para verificar se o tamanho do arquivo é permitido -->
                    <div style="display: none;">
                        <p>@lang('messages.max_filesize') em bytes: <b><span id="filesize-max">{{ \App\Document::getmaxUploadSizeInBytes() }}</span></b></p>
                        <p>@lang('messages.max_filesize') selecionado em bytes: <b><span id="filesize-selected"></span></b></p>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <input type="hidden" name="container_type_id" id="container_type_id">
                <input type="hidden" name="redirect" id="redirect">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.cancel')</button>
                <button type="submit" class="btn btn-primary">@lang('messages.confirm')</button>
            </div>
            {{ Form::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.css" >

@endpush
@push('js')

<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/inputmask/inputmask.min.js'></script>
<script>
    $('#modalAddDocument').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        //var id = button.data('id'); // Extract info from data-* attributes
        var text = button.data('text');
        var link = button.data('link');
        var redi = button.data('redirect');

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('#container_type_id').val(text);
        modal.find('#redirect').val(redi);
        modal.find('.modal-form').prop("action", link);
    })

    //Conferir o tamanho do arquivo selecionado
    $('#document').bind('change', function() {
        $("#filesize-selected").text(this.files[0].size);
    });

    //Ao tentar enviar dados, conferir se há arquivo selecionado e se ele tem tamanho permitido
    $('#upload-form').submit(function( event ) {
        if ( typeof $("#document").prop('files')[0] === "undefined" ) {
            event.preventDefault();
        } else if ( parseInt($("#filesize-selected").text()) >= parseInt($("#filesize-max").text()) ) {
            alert( " {{__('messages.max_filesize_alert')}} " );
            $('#document').val("");
            $("#filesize-selected").text("");
            event.preventDefault();
        }
    });

</script>
@endpush

