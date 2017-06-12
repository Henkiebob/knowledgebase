@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
<script type="text/javascript">
navigator.geolocation.getCurrentPosition(function(location) {
   console.log(location.coords.latitude);
   console.log(location.coords.longitude);
   console.log(location.coords.accuracy);
 });

</script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
