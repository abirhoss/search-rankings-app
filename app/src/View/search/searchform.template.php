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
			<h1 class="wv-heading--title">
				Google Search Rankings App
			</h1><br>
			<h2 class="wv-heading--subtitle">
				This app performs a Google search at google.com.au with the provided search keywords
			</h2><br>
			<h3>
				The search results are then processed to return a list of numbers where the target website URL is found in the Google results
			</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 mx-auto">
			<div class="myform form ">
				<!-- search form -->
				<form action='/?action=search_query' method='post'>
					<!-- search keywords field -->
					<div class="form-group">
						<label for="searchKeywords">Search Keywords</label>
						<input type="text" size="50" class="form-control" id="searchKeywords" name="searchKeywords" aria-describedby="searchKeywordsHelp" placeholder="creditorwatch" required>
					</div><br>

					<!-- target website field -->
					<div class="form-group">
						<label for="website">Target Website</label>
						<input type="text" size="30" pattern=".*\.com.*" class="form-control" id="website" name="website" placeholder="creditorwatch.com.au" required>
					</div><br>

					<!-- similar results field -->
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input" id="similarResults" name="similarResults">
						<label class="form-check-label" for="exampleCheck1">Include similar results</label>
					</div>

					<!-- form submit button -->
					<input type="submit" class="btn btn-primary btn-lg" value='Submit'>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
