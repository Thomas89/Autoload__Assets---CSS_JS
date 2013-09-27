<?php
require '../classes/autoload.php';
$autoload = new Autoload;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>MkAutoload</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<?php
        $cssincludes = null;
        if (isset($_POST['cssinclude'])) {
            $cssincludes = explode(',', $_POST['cssincludes']);
        }
        $cssexcludes = null;
        if (isset($_POST['cssexclude'])) {
            $cssexcludes = explode(',', $_POST['cssexcludes']);
        }
        
        try{
        if ($cssincludes!=null || $cssexcludes!=null) {
            echo $csstags=$autoload -> loadCss('css', $cssincludes, $cssexcludes);
            $css=2;
        } else {
            echo $csstags=$autoload -> loadCss('css', array('bootstrap.min.css', 'bootstrap-responsive.min.css'));
            $css=1;
        }
        }catch(AutoloadException $e){
            $css=1;
            echo $csstags=$autoload -> loadCss('css', array('bootstrap.min.css', 'bootstrap-responsive.min.css'));
            $error = $e->getMessage();
        }
        
        $jsincludes=null; 
        if(isset($_POST['jsinclude'])){
            $jsincludes=explode(',', $_POST['jsincludes']);
        }
        $jsexcludes=null; 
        if(isset($_POST['jsexclude'])){
            $jsexcludes=explode(',', $_POST['jsexcludes']);
        }
        try{
            if($jsexcludes!=null || $jsincludes!=null){
                $js=1;
                $jstags=$autoload->loadJs('js',$jsincludes,$jsexcludes) ;
            }else{
                $js=2;
                $jstags=$autoload->loadJs('js',array('jquery.js','bootstrap.min.js')) ;
            }
        }catch(AutoloadException $e){
            $js=2;
                $jstags=$autoload->loadJs('js',array('jquery.js','bootstrap.min.js')) ;
            $error = $e->getMessage();
        }
        
		?>
		
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
		</style>

	</head>

	<body>

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="brand" href="#">Mk Autoload</a>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li class="active">
								<a href="#">Home</a>
							</li>
							<li>
								<a href="#about">About</a>
							</li>
							<li>
								<a href="#contact">Contact</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">Action</a>
									</li>
									<li>
										<a href="#">Another action</a>
									</li>
									<li>
										<a href="#">Something else here</a>
									</li>
									<li class="divider"></li>
									<li class="nav-header">
										Nav header
									</li>
									<li>
										<a href="#">Separated link</a>
									</li>
									<li>
										<a href="#">One more separated link</a>
									</li>
								</ul>
							</li>
						</ul>
						<form class="navbar-form pull-right">
							<input class="span2" type="text" placeholder="Email">
							<input class="span2" type="password" placeholder="Password">
							<button type="submit" class="btn">
								Sign in
							</button>
						</form>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div class="container">
			<!-- Main hero unit for a primary marketing message or call to action -->
			<div class="hero-unit">
			    <?php 
			     if(isset($error)){
			         echo "<div class=\"alert alert-error\">
                          <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
                          <strong>Error:</strong> $error
                        </div>";
			     }
			    ?>
				<h1>Mk Autoload Examples</h1>
				<p>
					This is an example of the usage of the MkAutoload Class
				</p>
				<div class="row-fluid">
					<span class="span6"> <b>$cssinclude</b> <?php var_dump($cssincludes); ?> </span>
					<span class="span6"> <b>$cssexcludes</b> <?php var_dump($cssexcludes); ?> </span>
					
					
				</div>
				<b>Css load executed</b>
                <pre><?php echo $css==1?"\$autoload -> loadCss('css', array('bootstrap.min.css', 'bootstrap-responsive.min.css'));":" \$autoload -> loadCss('css', \$cssincludes, \$cssexcludes);" ?></pre>
                <b>Css tags generated</b>  
                <?php var_dump($csstags); ?>
                <div class="row-fluid">
                    <span class="span6"> <b>$jsinclude</b> <?php var_dump($jsincludes); ?> </span>
                    <span class="span6"> <b>$jsexcludes</b> <?php var_dump($jsexcludes); ?> </span>
                </div>
                <b>Js load executed</b>
                <pre><?php echo $js==1?"\$autoload->loadJs('js','\$jsincludes,\$jsexcludes) ;":"\$autoload->loadJs('js',array('jquery.js','bootstrap.min.js'))" ?></pre>
                <b>Js tags generated</b>  
                <?php var_dump($jstags); ?>
			</div>
			<h2>About the class</h2>
			<p>
				The class is a simple helper to autoload js and css.
			</p>
			<p>The class has inline documentation so you can know hoe to use it, it has 2 main functions: loadCss() and loadJs(),
			     both functions recive the next params in order: The name of the directory in that contains the files, an array 
			     whit the files you whant to upload if null loads all the format matching files in the directory, an array whit the
			     files you want to exclude from been loaded if null no files are excluded, an array whith extra propierties to our tag.
			     All the parameters are optional exept the directory name.   
			 </p>
			 <p>The class loads the files alfabethicaly if you donts send an include array, so if you need the files to be loaded in a
			     certain order you must send an include array</p>
			<p>
				You can see the repository on: <a href="https://github.com/m1k3777/mkAutoload" target="_blank">Github</a>
			</p>
			<hr/>
			<h2>About the autor</h2>
			<p>
				Im a Mexican guy so i have a lot of grammatical errors, so if you found that somthing is wrong plese forgive me, I do my best
			</p>
			<p>
				You can contact me on <a href="mailto:m1k3777@gmail.com">m1k3777@gmail.com</a>, <a href="https://twitter.com/m1k3777">Twitter</a>
				or <a href="https://github.com/m1k3777">Github</a>
			</p>
			<hr/>
			<h2>How to use this example</h2>
			<p>
				You can find a form below where you can choose the options to render the page again in the header of the pages you can see the code used and the generated code
			</p>
			<hr>
			<h2>Test me</h2>
			<form method="post">
				<fieldset>
					<legend>
						Stylesheet files to load
					</legend>
					<div class="row-fluid">
						<div class="span6">
							<label class="checkbox" for="cssinclude">
								<input type="checkbox" name="cssinclude" value="true" id="cssinclude" />
								Include this files </label>
							<label for="cssincludes">
								<input type="text" name="cssincludes" id="cssincludes" class="span12" value="amelia.css,bootstrap.min.css,bootstrap-responsive.min.css" />
							</label>
						</div>
						<div class="span6">
							<label class="checkbox" for="cssexclude">
								<input type="checkbox" name="cssexclude" value="true" id="cssexclude" />
								Exclude this files </label>
							<label for="cssexcludes">
								<input type="text" name="cssexcludes" id="cssexcludes" class="span12" value="amelia.css,bootstrap.min.css,bootstrap-responsive.min.css" />
							</label>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend>
						Javascript files to load
					</legend>
					<div class="row-fluid">
						<div class="span6">
							<label class="checkbox" for="jsinclude">
								<input type="checkbox" name="jsinclude" value="true" id="jsinclude" />
								Include this files </label>
							<label for="jsincludes">
								<input type="text" name="jsincludes" id="jsincludes" class="span12" value="jquery.js,bootstrap.min.js" />
							</label>
						</div>
						<div class="span6">
							<label class="checkbox" for="jsexclude">
								<input type="checkbox" name="jsexclude" value="true" id="jsexclude" />
								Exclude this files </label>
							<label for="jsexcludes">
								<input type="text" name="jsexcludes" id="jsexcludes" class="span12" value="jquery.js,bootstrap.min.js" />
							</label>
						</div>
					</div>
					<input type="submit" value="Try" class="btn btn-primary" />
				</fieldset>
			</form>

			<footer>
				<p>
					&copy; m1k3777 2013
				</p>
			</footer>

		</div>
		<!-- /container -->

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<?php
		echo $jstags;
		?>

	</body>
</html>
