<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">@lang('messages.documents')</h3>
        <div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Status">
            <div class="btn-group" data-toggle="btn-toggle">
                @can(['operator', 'admin'])
                <button type="button" class="btn btn-primary btn-sm" data-toggle='modal' data-target='#modalAddDocument'
                    data-link="{{route('documents.store')}}"
                    data-redirect="{{route('container_types.edit', $container_type)}}"
                    data-text='{{$container_type->id}}'>
                    <i class="fa fa-plus"></i> @lang("messages.add_document")
                </button>
                @endcan
            </div>
        </div>
    </div>
    <div class="box-body">
        @if ($agent->isMobile())
            <style>
                tbody tr:nth-child(even) {
                    background-color: #eee;
                }
            </style>
        @else
            <style>
                tbody tr:hover {
                    background-color: #ddd;
                }
            </style>
        @endif
        <table class="table table-borderless table-condensed table-fit">
            <thead>
                <tr>
                    <th width='2%'></th>
                    <th width="50%">@lang("messages.document")</th>
                    <th width="10%">@lang("messages.filesize")</th>
                    <th width='5%'>@lang("messages.actions")</th>
                </tr>
            </thead>
            <tbody>
            @forelse($container_type->documents as $d)

            <tr>
                <td with='5%'>
                    <i class="fa fa-{{$d->extension_icon}}"></i>
                </td>
                <td  data-toggle="tooltip" title="{{$d->description}}">{{$d->name}}</td>
                <td  data-toggle="tooltip" >{{$d->filesize}}</td>

                <td>
                    <a class='btn btn-xs btn-success' href="{{route('documents.download', $d)}}" data-text='{{$d->id}}'><i class="fa fa-download"></i></a>
                    @can(['operator', 'admin'])
                    <button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#modalExcludeConfirm' data-link="{{route('documents.destroy', $d)}}" data-text='{{$d->name}}'><i class="fa fa-trash"></i></button>
                    @endcan
                </td>
            </tr>
            @empty
                <tr><th colspan="3" class='text-center'>@lang("messages.no_documents")</th></tr>
            @endforelse
            <tbody>
        </table>
    </div>
</div>

