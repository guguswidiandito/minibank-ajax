@extends('layouts.template')
@section('content')
<div class="x_panel">
	<div class="x_title">
		<h2>Home</h2>
		<ul class="nav navbar-right panel_toolbox">
			<li>
				<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
			</li>
			<li>
				<a class="close-link"><i class="fa fa-close"></i></a>
			</li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		You are logged in!
	</div>
</div>
@endsection