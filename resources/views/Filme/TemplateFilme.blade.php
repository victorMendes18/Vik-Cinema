<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="{{url('CSS\estilo.css')}}">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<title>{{$titulo}}</title>
	</head>
	<body>
		<div class="container">
			@yield('viewFilme')
		</div>

	</body>
</html>