<?php

/*
 *
 * Build out the data-structure driving the page navigation markup
 *
 */
$navigationMenuItems = getNavigationMenu( 'Primary' );

?>

<? /*
<!-- Header Section -->
<section class="header-section">
	<div class="container">
		<div class="header row">
			<div class="columns small-3">
				<a class="logo" href="/">
					<img src="media/logo.svg<?php echo $ver ?>">
				</a>
			</div>
			<div class="text-right columns small-9">
				<div class="navigation inline">
					<?php foreach ( $navigationMenuItems as $item ) : ?>
						<a class="button js_nav_button" href="<?php echo $item[ 'url' ] ?>"><?php echo $item[ 'label' ] ?></a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section> <!-- END : Header Section -->
*/ ?>

<!-- Menu Section -->
<section class="menu-section">
	<div class="container">
		<div class="menu-button fill-blue-4 inline" tabindex="-1">
			<span class="menu-label h6"></span>
			<span class="menu-icon">
				<span></span>
				<span></span>
				<span></span>
			</span>
		</div>
	</div>
</section>
<!-- END: Menu Section -->


<!-- Navigation Section -->
<section class="navigation-section">
	<div class="container text-right">
		<div class="nav-list inline fill-blue-4 text-left space-75 space-200-bottom">
			<div class="title h2 strong text-blue-3 space-50-bottom">Menu</div>
			<a tab-index="-1" href="" class="link h5 strong block line-height-large">Benefits</a>
			<a tab-index="-1" href="" class="link h5 strong block line-height-large">Investment</a>
			<a tab-index="-1" href="" class="link h5 strong block line-height-large">How does it work?</a>
			<a tab-index="-1" href="" class="link h5 strong block line-height-large">FAQs</a>
			<a tab-index="-1" href="" class="link h5 strong block line-height-large">Testimonials</a>
			<a tab-index="-1" href="" class="link h5 strong block line-height-large">Help Center</a>
		</div>
		<div tab-index="-1" class="nav-close-area"></div>
	</div>
</section>
<!-- END: Navigation Section -->