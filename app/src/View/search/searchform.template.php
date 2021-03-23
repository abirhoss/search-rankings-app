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
			<h1 class="wv-heading--title">
				Google Search Rankings App
			</h1><br>
			<h2 class="wv-heading--subtitle">
				This app performs a Google search at google.com.au with the provided search keywords
			</h2><br>
			<h3>
				The search results are then processed to return a list of numbers where the target URL's domain is found in the Google results
			</h3>
		</div>
	</div>
	<div class="col-md-10 mx-auto jumbotron">
		<div class="search-form form ">
			<!-- search form -->
			<form action='/?action=search_query' method='post'>
				<!-- search keywords field -->
				<div class="form-inline form-group">
					<label class="mr-2" for="searchKeywords"><b>Search Keywords: </b></label>
					<input type="text" size="40" class="form-control" id="searchKeywords" name="searchKeywords" aria-describedby="searchKeywordsHelp" placeholder="creditorwatch" required>
				</div>

				<!-- target url field -->
				<div class="form-inline form-group">
					<label class="mr-2" for="url"><b>Target URL: </b></label>
					<input type="text" size="40" pattern=".*\.com.*" class="form-control" id="url" name="url" placeholder="creditorwatch.com.au" required>
				</div>

				<!-- include omitted results field -->
				<div class="form-inline form-group form-check">
					<input type="checkbox" class="mr-4 form-check-input" id="includeOmittedResults" name="includeOmittedResults">
					<label class="form-check-label" for="includeOmittedResults">Include omitted results</label>
				</div>

				<!-- form submit button -->
				<input type="submit" class="btn btn-primary btn-lg btn-block col-md-6 mx-auto" value='Search'>
			</form>
		</div>
	</div>
</div>
</body>
</html>
