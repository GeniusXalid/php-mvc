<?php
class Landing_Land_CircuitModel extends CircuitModel {

	public function getnewBlog() {
		global $wpdb;
		$r=array();
		$blogs = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs WHERE
		public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' AND blog_id != '1'
		ORDER BY last_updated DESC");
		foreach ($blogs as $blog) {
			$blogOptionsTable = "wp_".$blog."_options";
			$blogPostsTable = "wp_".$blog."_posts";
			$blogCommentsTable = "wp_".$blog."_comments";
			$blogMetaTable = "wp_".$blog."_postmeta";

			$thispost = $wpdb->get_results("SELECT id, post_title,post_excerpt, post_date, post_author,comment_count
			FROM $blogPostsTable WHERE post_status = 'publish' AND post_type = 'post'
			ORDER BY id DESC limit 0,1");

			$thisauthor=$wpdb->get_results("SELECT display_name,user_email,user_login
                                 FROM wp_users WHERE id = ".$thispost[0]->post_author);

			$views = $wpdb->get_results("SELECT meta_value as views FROM $blogMetaTable
			where meta_key ='views' and post_id = ".$thispost[0]->id);

			$tags=$this->get_tags($blog,$thispost[0]->id);

			$thispermalink = get_blog_permalink($blog, $thispost[0]->id);
			$m=array_merge((array)$thispost[0],(array)$views[0],array("url"=>$thispermalink),(array)$tags,(array)$thisauthor[0]);
			array_push($r,$m);
	 }
	 return $r;

	}

	//获取群组博客最新5片文章
	public function getGroupList(){
		global $wpdb;
		$group_l=array();
		$group_id=array(0=>"自由博客",1=>"运维部",2=>"PHP部",3=>"JAVA部",4=>"Apple",5=>"前端");
		foreach($group_id as $id => $v){
			$r=array();
			$blogs = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs WHERE
			public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' AND blog_id != '1' and group_id = $id
			ORDER BY last_updated DESC limit 5");				
			foreach ($blogs as $blog) {
				$blogPostsTable = "wp_".$blog."_posts";
				$thispost = $wpdb->get_results("SELECT id, post_title
				FROM $blogPostsTable WHERE post_status = 'publish' AND post_type = 'post'
				ORDER BY id DESC limit 0,1");
			    $thispermalink = get_blog_permalink($blog, $thispost[0]->id);	
				$m=array_merge((array)$thispost[0],array("url"=>$thispermalink));
				array_push($r,$m);
			}

				$mm=array($id=>array($r,"title"=>$v));
				$group_l+=$mm;
		
		}
	
		return $group_l;
	}


	//获取标签
	function get_tags($blog,$id) {
		global $wpdb;
		$blogTerm = "wp_".$blog."_terms";
		$blogRelationships = "wp_".$blog."_term_relationships";
		$blogTaxonomy = "wp_".$blog."_term_taxonomy";

		$term_taxonomy_id= $wpdb->get_results("SELECT term_taxonomy_id FROM $blogRelationships where object_id = ".$id);
		foreach($term_taxonomy_id as $v){
			$taxonomysql=$taxonomysql.",".$v->term_taxonomy_id;
			$taxonomyadd=$v->term_taxonomy_id;
		}
		if(isset($taxonomysql)){
			$taxonomysql=$taxonomyadd.$taxonomysql;
			$term_ids = $wpdb->get_results("SELECT term_id,count FROM $blogTaxonomy where term_taxonomy_id in ($taxonomysql) and taxonomy = 'post_tag'");
			foreach($term_ids as $v){
				$termsql=$termsql.",".$v->term_id;
				$termadd=$v->term_id;
				$termr[$v->term_id]=$v->count;
			}
			if(isset($termsql)){
				$termsql=$termadd.$termsql;
				$sqltags= $wpdb->get_results("SELECT term_id,name FROM $blogTerm where term_id in($termsql)");
				foreach($sqltags as $v){
					$tagarry[$v->term_id]["term_id"]=$v->term_id;
					$tagarry[$v->term_id]["name"]=$v->name;
					$tagarry[$v->term_id]["count"]=$termr[$v->term_id];
				}
				return array("tags"=>$tagarry);
			}
		}
		return null;
	}



}