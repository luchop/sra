<script type="text/javascript">
//<!--
/*var t=$('content');
var t2=$('sidebar').offsetHeight;
if(t.offsetHeight<t2)
	t.style.height=t2+20+"px";*/
// -->
</script>
<div class="clear_both"></div>
<div id="footer">
	<div class="footer_top"><div class="footer_top_left"></div><div class="footer_top_right"></div></div>
	<div class="footer_c">
		
		<div class="footer_left">
			<div class="footer_title">Recent Posts</div>
			<ul class="footer_list"><?php
				
					$data=$wpdb->get_results("SELECT 
												`ID`,`post_title` 
												FROM `{$wpdb->posts}` 
												WHERE 
													`post_type`='post' AND
													`post_status`='publish'
												ORDER BY 
													`post_date` DESC 
												LIMIT 10",ARRAY_A);
					if(is_array($data))
						foreach($data as $post)
							{echo '<li><a href="',get_option('home').'?p=',$post['ID'],'">';
								echo array_shift(explode("\r\n",wordwrap($post['post_title'],40," ...\r\n",true)));
							echo '</a></li>';
							}
				?></ul>
		</div>
			
		<div class="footer_center">
			<div class="footer_title">Recent comments</div>
			<ul class="footer_list"><?php
				
					$data=$wpdb->get_results("
										SELECT 
											`comment_post_id`,
											`comment_author`, 
											SUBSTRING(comment_content,1,50) AS `content` 
										FROM 
											`{$wpdb->comments}`
										WHERE
											`comment_approved`='1'
											
										ORDER BY `comment_date` DESC
										LIMIT 10",ARRAY_A);
					if(is_array($data))
						foreach($data as $post)
							{echo '<li><a href="',get_option('home').'?p=',$post['comment_post_id'],'#comments">',$post['comment_author'],' - ';
							
							echo array_shift(explode("\r\n",wordwrap(strip_tags($post['content']),29," ...\r\n",true)));
							
							echo ' </a></li>';
							}
				?></ul>
			</div>
		<div class="footer_right">
				<div class="footer_title" style="margin:0px;">Tag Cloud</div><?php
				$data=array(
						'smallest' => 9,
						'largest' => 30,
						'unit' => 'pt',
						'number' => 45,
						'format' => 'flat',
						'orderby' => 'name', 
						'order' => 'ASC'
						
						);
				echo wp_generate_tag_cloud(get_tags(),$data);
					
		?></div>
	</div>
	
	<div class="footer_bottom">
		<div class="footer_sv_corner"></div><div class="footer_se_corner"></div>
	</div>

</div>
<div class="clear_both"></div>
</div></div></div>
<div class="sub_footer">
	<!-- If you'd like to support WordPress, having the "powered by" link somewhere on your blog is the best way; it's our only promotion or advertising. -->
	Copyright &copy; <?php echo date('Y') ?> <b><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></b> 	which is powered by	<a href="http://wordpress.org/">WordPress</a><br />
	Stylecious template by <a href="http://thaslayer.com/">ThaSlayer</a>
</div><?php wp_footer(); ?>
</body>
</html>
