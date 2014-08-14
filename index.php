<?php
require_once 'resource/Det.php';
$det = new Det();
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title><?php echo $det->getName(); ?></title>
	<link rel="stylesheet" href="stylesheets/icons/foundation-icons.css"/>
	<link rel="stylesheet" href="stylesheets/app.css"/>
	<script src="bower_components/modernizr/modernizr.js"></script>
</head>
<body>
<div class="fixed">
	<nav class="top-bar" data-topbar>
		<ul class="title-area">
			<li class="name">
				<h1><a href="#" id="brand"><?php echo $det->getName(); ?></a></h1>
			</li>
			<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
			<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
		</ul>

		<section class="top-bar-section">
			<ul class="right">
				<!-- Search | has-form wrapper -->
				<li class="has-form">
					<div class="row collapse">
						<div class="large-8 small-9 columns">
							<input type="text" placeholder="Find Stuff">
						</div>
						<div class="large-4 small-3 columns">
							<a class="button expand" href="#">Search</a>
						</div>
					</div>
				</li>
				<li><a href="info.php" target="_blank"><i class="fi-wrench"></i> phpinfo</a></li>
			</ul>
			<ul class="left">
				<li><a href="#" data-reveal-id="systemModal"><i class="fi-info"></i> SystemInfo</a></li>
				<li><a href="#" data-reveal-id="extensionsModal"><i class="fi-widget"></i> Extensions</a></li>
			</ul>
		</section>
	</nav>
	<nav class="tab-bar show-for-small">
		<a class="left-off-canvas-toggle menu-icon">
			<span><?php echo $det->getName(); ?></span>
		</a>
	</nav>
</div>
<br>
<section>
	<div class="row">
		<div class="large-3 medium-4 columns">
			<div class="hide-for-small">
				<div class="sidebar">
					<nav>
						<ul id="" class="side-nav">
							<li class="heading">Products</li>
							<?php
							if ($det->containProducts()) {
								echo '<li class="divider-vertical"></li>';
								foreach ($det->getProducts() as $product) {
									echo '<li><a href="#p_' . strtolower($product->name) . '">' . $product->name . '</a></li>';
								}
							}
							?>

							<?php if ($det->containContents()): ?>
								<li class="divider"></li>
								<li class="heading">Content</li>
								<?php foreach ($det->getContents() as $content): ?>
									<li>
										<a href="#c_<?php echo strtolower($content->name); ?>"><?php echo $content->name; ?></a>
									</li>
								<?php endforeach; ?>
							<?php endif; ?>

							<?php if ($det->containLinks()): ?>
								<li class="divider"></li>
								<li class="heading">Other stuff</li>
								<li><a href="#links">Links</a></li>
							<?php endif; ?>
						</ul>
					</nav>


				</div>
			</div>
		</div>
		<div class="large-9 medium-8 columns">
			<?php foreach ($det->getProducts() as $product): ?>
				<section class="panel main" id="p_<?php echo strtolower($product->name); ?>">
					<h2><?php echo $product->getName(); ?></h2>

					<div class="flex-container">
						<?php foreach ($product->instances as $instance): ?>
							<div class="flex-item">
								<h4><?php echo $instance->name; ?>
									<small><?php echo $instance->version; ?></small>
								</h4>
								<?php if (!empty($instance->pages)): ?>
									<table class="small-12">
										<tbody>
										<tr>
											<td colspan="5"><?php echo implode(' | ', $instance->pages); ?></td>
										</tr>
										</tbody>
									</table>
								<?php else: ?>
									<table class="small-12">
										<tbody>
										<tr>
											<td><?php echo $instance->links->app; ?></td>
											<td><?php echo $instance->links->fw; ?></td>
											<td><?php echo $instance->links->svn; ?></td>
											<td><?php echo $instance->links->bds; ?></td>
											<td><?php echo $instance->links->content; ?></td>
										</tr>
										</tbody>
									</table>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endforeach; ?>

			<?php foreach ($det->getContents() as $content): ?>
				<section class="panel main" id="c_<?php echo strtolower($content->name); ?>">
					<h2><?php echo $content->name; ?></h2>
					<div class="flex-container">
						<div class="flex-item">
							<table class="small-12">
								<tbody>
								<tr>
									<td><?php echo $content->data; ?></td>
									<td><?php echo $content->svn; ?></td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
				</section>
			<?php endforeach; ?>

			<section class="panel main" id="links">
				<h2 id="links">Links</h2>
				<ul class="no-bullet">
					<?php foreach ($det->getLinks() as $link): ?>
						<li><?php echo $link->url; ?></li>
					<?php endforeach; ?>
				</ul>
			</section>
		</div>
	</div>
</section>

<div id="extensionsModal" class="reveal-modal small" data-reveal>
	<h3>Loaded extensions</h3>
	<ul class="no-bullet threecolumns">
		<?php foreach ($det->getExtensions() as $extension): ?>
			<li><?php echo $extension; ?></li>
		<?php endforeach; ?>
	</ul>
	<a class="close-reveal-modal">&#215;</a>
</div>

<div id="systemModal" class="reveal-modal small" data-reveal>
	<h3>System information</h3>
	<table>
		<tbody>
		<tr>
			<td>OS</td>
			<td><?php echo $det->getSystemInfo()->os;?></td>
		</tr>
		<tr>
			<td>Apache</td>
			<td><?php echo $det->getSystemInfo()->apache;?></td>
		</tr>
		<tr>
			<td>PHP</td>
			<td><?php echo $det->getSystemInfo()->php;?></td>
		</tr>
		<tr>
			<td colspan="2"><?php echo $det->getSystemInfo()->uname;?></td>
		</tr>
		</tbody>
	</table>
	<a class="close-reveal-modal">&#215;</a>
</div>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/foundation/js/foundation.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
