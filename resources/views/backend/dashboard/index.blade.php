@extends('backend.layouts.header')

@section('content')
<div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3>Dashboard</h3>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footers')
<script type="text/javascript">
    //Active Class 
    $("#dashboard-menu").show(function() {
        $title = $('#dashboard-menu').addClass('active');
    });
</script>
@endsection