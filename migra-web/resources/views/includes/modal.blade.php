<div class="modal fade modal-danger " tabindex="-1" role="dialog" id='modalExcludeConfirm'>
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">@lang('messages.remove_row')</h4>
      </div>
      <div class="modal-body">
          <h2>One fine body&hellip;</h2>
      </div>
      <div class="modal-footer">
        {{ Form::open(['method' => 'delete', 'style'=>'display:inline', 'class'=>'modal-form']) }}

        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">@lang('messages.cancel')</button>
        <button type="submit" class="btn btn-sm btn-primary">@lang('messages.confirm')</button>
        {{ Form::close() }}

      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
@push('js')
<script>
$('#modalExcludeConfirm').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    //var id = button.data('id'); // Extract info from data-* attributes
    var text = button.data('text');
    var link = button.data('link');
    
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body h2').html(text);
    modal.find('.modal-form').prop("action", link);
}) 
</script>
@endpush

