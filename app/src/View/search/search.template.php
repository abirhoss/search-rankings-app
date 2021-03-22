<!doctype html>
<html>

<head>
	<link rel="stylesheet" href="../../../static/bootstrap.min.css">
	<link rel="stylesheet" href="../../../static/style.css">
</head>

<body>
<div class="container">
	<div class="col-md-12 mx-auto text-center">
		<div class="header-title">
			<h1>Search Results</h1><br>
			<!-- search metadata -->
			<h4>The domain "<?= $vars['domain'] ?>" was found <?= $vars['domainCount'] ?> times in the following rank positions within the first <?= $vars['resultsLimit'] ?> Google search results for your search keywords "<?= $vars['searchKeywords'] ?>"</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 mx-auto jumbotron">
			<!-- search rankings list -->
			<h1 class="rankings">Rankings: "<?= $vars['rankingList'] ?>"</h1><br><br>
			<h2>Search Keywords: "<?= $vars['searchKeywords'] ?>"</h2><br>
			<h2>Target Url: "<?= $vars['url'] ?>"</h2><br>
			<h2>Target Domain: "<?= $vars['domain'] ?>"</h2><br>
			<h2>Target Domain Count: "<?= $vars['domainCount'] ?>"</h2><br>
			<h2>Results Limit: "<?= $vars['resultsLimit'] ?>"</h2><br>
			<h2>Include Omitted Results: "<?= $vars['omittedResults'] ?>"</h2>
		</div>
	</div>
	<div class="row mb-5">
		<div class="col-md-6 mx-auto">
			<a class="btn btn-primary btn-lg btn-block mb-5" href="/" role="button">Perform another search</a>
		</div>
	</div>
</div>
</body>
</html>
