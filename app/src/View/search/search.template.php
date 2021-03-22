<!doctype html>
<html>

<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="stylesheet" href="../../../static/style.css">
</head>

<body>
<div class="container">
	<div class="col-md-12 mx-auto text-center">
		<div class="header-title">
			<h1>Search Results</h1><br>
			<!-- search metadata -->
			<h4>The website <?= $vars['website'] ?> appeared <?= $vars['websiteCount'] ?> times in the following rank positions within the first <?= $vars['resultsLimit'] ?> Google search results for your search keywords: <?= $vars['searchKeywords'] ?></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 mx-auto">
			<!-- search rankings list -->
			<h1>Rankings: "<?= $vars['rankingList'] ?>"</h1><br>
			<h2>Search Keywords: "<?= $vars['searchKeywords'] ?>"</h2><br>
			<h2>Target Website: "<?= $vars['website'] ?>"</h2><br>
			<h2>Target Website Count: "<?= $vars['websiteCount'] ?>"</h2><br>
			<h2>Include Similar Results: "<?= $vars['similarResults'] ?>"</h2><br>
		</div>
	</div><br>
	<div class ="row">
		<div class="col-md-12 mx-auto">
			<a class="btn btn-primary btn-lg" href="/" role="button">Perform another search</a>
		</div>
	</div>
</div>
</body>
</html>
