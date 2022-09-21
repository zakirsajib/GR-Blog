<?php
// Zakir Added
function blog_filter_view() { ?>

  <div class="stories-post mt-5 md:mt-10 md:flex md:self-center md:justify-start">
      <div class="filter-button-post">
          <div class="sub-stories-post md:mr-5 md:mb-0 md:mt-0 btn border bg-gray-900 text-white text-body justify-center font-semibold mb-4 cursor-pointer">
              All
          </div>
      </div>
  	<?php
  	$categories = get_categories( array(
  		'type'         => 'post',
  		'child_of'     => 0,
  		'parent'       => 0,
  		'orderby'      => 'name',
  		'order'        => 'DESC',
  		'hide_empty'   => 0,
  		'hierarchical' => 1,
  		'include'      => '',
  		'number'       => 0,
  		'taxonomy'     => 'category',
  		'pad_counts'   => false,
  	) );

  	foreach ( $categories as $cat ){
  		$options = get_categories( array(
  			'type'         => 'post',
  			'child_of'     => 0,
  			'parent'       => $cat->term_id,
  			'orderby'      => 'name',
  			'order'        => 'ASC',
  			'hide_empty'   => 0,
  			'hierarchical' => 1,
  			'exclude'      => '',
  			'include'      => '',
  			'number'       => 0,
  			'taxonomy'     => 'category',
  			'pad_counts'   => false,
  		) );

  		?>
  		<div class="filter-button-post relative">

              <select name="post-filter" class="arrow-right-btn bg-transparent hover:bg-gray-100 md:mr-5 md:mb-0 md:pr-10 btn border border-gray-900 text-btn text-gray-900 font-medium justify-start uppercase px-8 mb-4">

                  <option value="<?php echo $cat->slug; ?>">BY <?php echo $cat->name; ?></option>
          				<?php if( !empty($options) ){ ?>

          					<?php foreach ( $options as $option ){ ?>
                      <option value="<?php echo $option->slug; ?>">
          							<?php echo $option->name; ?>
                      </option>
          					<?php } ?>
          				<?php } ?>
              </select>
  		</div>
  		<?php
  	}
  	?>

  </div>

  <?php
  }

  function post_filter_ajax(){
  	if ( isset($_REQUEST) ) {
  		$category = $_REQUEST['category'];
  		$post_type = 'post';
      $per_page = get_option( 'posts_per_page' );
      $paged = $_REQUEST['paged'] ?: 1;

  		$term_arr = [
  			'taxonomy' => 'category',
  			'field' => 'slug',
  			'terms' => $category,
  		];

  		if ( empty($category) ){
  			$args = array(
  				'post_type' => 'post',
  				'posts_per_page' => $per_page,
  				'paged' => $paged,
  			);
  		}else{
  			$args = array(
  				'post_type' => 'post',
  				'paged' => $paged,
  				'tax_query' => array(
  					$term_arr
  				),
  			);
  		}

  		$query = new WP_Query( $args );?>
      <div class="md:container md:mx-auto">
  			<?php
  			$count = 0;
  			$html = '';

  			while ( $query->have_posts() ) :
  				$query->the_post();
  				$sticky_post = has_term('14', 'category', get_the_ID() );
  				if( $sticky_post && $count == 0 ){
  					get_template_part( 'template-parts/taxonomy/taxonomy-featured', get_post_type() );
  					$count++;
  				}else{
            ob_start();
            get_template_part( 'template-parts/taxonomy/taxonomy', get_post_type() );
            $html .= ob_get_clean();
  				}
  				/*
  				 * Include the Post-Type-specific template for the content.
  				 * If you want to override this in a child theme, then include a file
  				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
  				 */

  			endwhile;
  			?>

        <div class="bottom-stories md:grid md:grid-cols-3 md:gap-12">
  				<?php echo $html; ?>
        </div>

        <div class="pagination globerunner-ajax-pagination pt-6 md:pt-20">
            <?php
            custom_pagination( $query, true, $paged );
            ?>
        </div>
      </div>
  <?php
  	}
  	die();
  }

  add_action( 'wp_ajax_post_filter_ajax', 'post_filter_ajax' );
  add_action( 'wp_ajax_nopriv_post_filter_ajax', 'post_filter_ajax' );




function case_studies_filter_view(){

?>
<div class="stories mt-5 md:mt-10 md:flex md:self-center md:justify-start">

    <div class="filter-button">
        <div class="sub-stories md:mr-5 md:mb-0 md:mt-0 btn border bg-gray-900 text-white text-body justify-center font-semibold mb-4 cursor-pointer">
            All
        </div>
    </div>
	<?php
	$categories = get_categories( array(
		'type'         => 'case-sudies',
		'child_of'     => 0,
		'parent'       => 0,
		'orderby'      => 'name',
		'order'        => 'DESC',
		'hide_empty'   => 0,
		'hierarchical' => 1,
		'exclude'      => '14',
		'include'      => '',
		'number'       => 0,
		'taxonomy'     => 'case-studies-category',
		'pad_counts'   => false,
	) );

	foreach ( $categories as $cat ){
		$options = get_categories( array(
			'type'         => 'case-sudies',
			'child_of'     => 0,
			'parent'       => $cat->term_id,
			'orderby'      => 'name',
			'order'        => 'DESC',
			'hide_empty'   => 0,
			'hierarchical' => 1,
			'exclude'      => '',
			'include'      => '',
			'number'       => 0,
			'taxonomy'     => 'case-studies-category',
			'pad_counts'   => false,
		) );

		?>
		<div class="filter-button relative">

            <select name="case-studies-filter" class="arrow-right-btn bg-transparent hover:bg-gray-100 md:mr-5 md:mb-0 md:pr-10 btn border border-gray-900 text-btn text-gray-900 font-medium justify-start uppercase px-8 mb-4">

                <option value="<?php echo $cat->slug; ?>">BY <?php echo $cat->name; ?></option>
        				<?php if( !empty($options) ){ ?>

        					<?php foreach ( $options as $option ){ ?>

                                <option value="<?php echo $option->slug; ?>">
        							<?php echo $option->name; ?>
                                </option>

        					<?php } ?>

        				<?php } ?>

            </select>

		</div>

		<?php
	}
	?>

</div>

<?php
}

function case_studies_filter_ajax(){
	if ( isset($_REQUEST) ) {
		$category = $_REQUEST['category'];
		$post_type = 'case-studies';
        $per_page = get_option( 'posts_per_page' );

        $paged = $_REQUEST['paged'] ?: 1;

		$term_arr = [
			'taxonomy' => 'case-studies-category',
			'field' => 'slug',
			'terms' => $category,
		];

		if ( empty($category) ){
			$args = array(
				'post_type' => $post_type,
				'posts_per_page' => $per_page,
				'paged' => $paged,
			);
		}else{
			$args = array(
				'post_type' => $post_type,
				'paged' => $paged,
				'tax_query' => array(
					$term_arr
				),
			);
		}

		$query = new WP_Query( $args );

        ?>
        <div class="md:container md:mx-auto">
			<?php
			$count = 0;
			$html = '';

			while ( $query->have_posts() ) :
				$query->the_post();

				$sticky_post = has_term('14', 'case-studies-category', get_the_ID() );

				if( $sticky_post && $count == 0 ){

					get_template_part( 'template-parts/taxonomy/taxonomy-featured', get_post_type() );

					$count++;

				}else{

                    ob_start();

                    get_template_part( 'template-parts/taxonomy/taxonomy', get_post_type() );

                    $html .= ob_get_clean();

				}
				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */

			endwhile;
			?>

            <div class="bottom-stories md:grid md:grid-cols-3 md:gap-12">
				<?php echo $html; ?>
            </div>

            <div class="pagination globerunner-ajax-pagination pt-6 md:pt-20">

	            <?php
	            custom_pagination( $query, true, $paged );
	            ?>

            </div>

        </div>
<?php
	}

	die();
}

add_action( 'wp_ajax_case_studies_filter_ajax', 'case_studies_filter_ajax' );
add_action( 'wp_ajax_nopriv_case_studies_filter_ajax', 'case_studies_filter_ajax' );
