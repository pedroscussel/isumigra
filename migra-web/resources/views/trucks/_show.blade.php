
<div class="row">
    <div class="col-sm-6">
        <label>@lang('messages.license_plate')</label>
        <p>{{ $truck->license_plate}}</p>
    </div>
    <div class="col-sm-6">
        <label>@lang('messages.identify')</label>
        <p>{{ $truck->name}}</p>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <label>@lang('messages.is_defect')</label>
        <p>
            @if($truck->is_defect)
            <span class="label label-danger">@lang('messages.yes')</span>
            @else
            <span class="label label-success">@lang('messages.no')</span>
            @endif
        </p>
    </div>
    <div class="col-sm-6">
        <label>@lang('messages.is_outofservice')</label>
        <p>
            @if($truck->is_outofservice)
            <span class="label label-danger">@lang('messages.yes')</span>
            @else
            <span class="label label-success">@lang('messages.no')</span>
            @endif
        </p>
    </div>
</div>
<!-- @ if(Gate::allows('business_migra')) -->
@if(Gate::allows('migra'))
<div class="row">
    <div class="col-sm-12">
        <label>@lang('messages.company')</label>
        <p><a href='{{route('companies.show', $truck->company)}}'>{{ $truck->company->name}}</a></p>
    </div>
</div>
@endif



