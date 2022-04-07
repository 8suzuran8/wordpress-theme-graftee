<?php
/**
 * @package graftee
 */
?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
	<label for="s">
		Search for:
		<meta itemprop="target" content="<?php echo home_url( '' ); ?>/?s={query}" />
		<input type="text" value="" name="s" id="s" role="textbox" itemprop="query-input" />
	</label>

	<input type="submit" id="searchsubmit" value="Search" role="button" />
</form>