<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" /><!--[if lt IE 7]><link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/style_ie.css" /><![endif]-->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/js.js"></script>
<script type="text/javascript">
	var rbet_engine='<?php echo get_bloginfo('template_directory'); ?>/rbet_engine.php';
	var wp_url='<?php echo get_option('home'); ?>';
	var wp_theme_adr='<?php echo get_bloginfo('template_directory'); ?>';
	/* 
	#################
	
	Plese set this to true if you use rewrite your URLs
	it will turn off ajax navigation

	#################
	*/
	var uses_mod_rewrite=true;
</script>
<?php wp_head(); ?>
</head>
<body>

<div id="page">
<div class="page_holder">

<div class="left_shadow">

<div id="header">
	<div class="header_top"></div>
	<div class="header_nv_corner"></div>
	<div class="header_ne_corner"></div>
	
	<div class="header_bg1">
		<div class="header_bg2">
			<a href="<?php echo get_option('home'); ?>/"><object><div class="logo" style="<?php

$browserdetect='';
if (strpos($_SERVER['HTTP_USER_AGENT'],'IE')!==false)
	if (strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0')!==false)
		$browserdetect="ie";
	else
		$browserdetect="ie7";
if ($browserdetect==''&&strpos($_SERVER['HTTP_USER_AGENT'],'Mozilla')!==false&&strpos($_SERVER['HTTP_USER_AGENT'],'IE')===false)
	$browserdetect="mozilla";
if ($browserdetect==''&&strpos($_SERVER['HTTP_USER_AGENT'],'Opera')!==false)
	$browserdetect="opera";
if (empty($browserdetect))
	$browserdetect="unknown";

function png_bg($w,$browserdetect)
	{
	if ($browserdetect=='ie')
		{
		$ext=array_pop(explode('.',$w));
		if($ext=='png')
			$re="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='$w',sizingMethod='scale');";
		else
			$re="background:url($w);";
		}
	else
		$re="background:url($w);";
	
	echo $re;
	
	}
png_bg(get_bloginfo('template_directory').'/images/logo.png',$browserdetect);
	
?>"></div></object></a>
			<div class="header_title">
				<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
				<div class="header_title_description"><?php bloginfo('description'); ?></div>
			</div>
			<div id="main_menu">
				<ul>
					<?php
					$data=$wpdb->get_results("SELECT 
													`ID`,
													`post_title` 
												FROM `{$wpdb->posts}` 
												WHERE 
													`post_type`='page' AND
													`post_status`='publish'
													
												ORDER BY
													`menu_order` AND `post_date` DESC 
												",ARRAY_A);
					if(is_array($data))
						foreach($data as $post)
							echo '<li><a href="',get_option('home').'?page_id=',$post['ID'],'">',$post['post_title'],'</a></li>';
					?>
					<li><a href="<?php echo get_option('home'); ?>">Home</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="header_bottom">
	<div class="header_bottom_v"></div>
	<div class="header_bottom_e"></div>
</div>
<a name="top"></a>