@push('js')
<script src="{{ asset('js/funcs.js') }}" defer>

</script>
<script>
$(document).ready(function() {
    
    changeSelect("[name='country_id']", "[name='state_id']", "{{asset('country/states/')}}");
    changeSelect("[name='state_id']", "[name='city_id']", "{{asset('state/cities/')}}");
});
</script>
@endpush

