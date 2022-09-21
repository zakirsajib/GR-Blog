<?php
$link = get_the_permalink();
//$category = get_the_terms( get_the_ID(), 'case-studies-category' );

$date = get_the_date('F j, Y');

$excerpt = get_the_excerpt();

$excerpt = substr( $excerpt, 0, 135 ); // Only display first 80 characters of excerpt


$author = get_field( 'author' );
if ( !empty( $author ) ){
    // Author data from Team post type
    $id = $author->ID;
    $author_title = $author->post_title;
    $author_link = get_permalink($id);
}

?>

<div <?php post_class('item py-4 md:py-0'); ?> >
    <div class="img mb-6 md:max-h-290 md:overflow-hidden">
        <a href="<?php echo $link;?>">
            <img loading="lazy" class="mx-auto" src="<?php the_post_thumbnail_url( 'card' );?>" alt="<?php the_title();?>">
        </a>
    </div>
    <div class="inner">
        <div class="category font-medium mb-1 text-body text-gray-600 text-shadow">
            <?php echo $date; ?>
	        <?php if ( !empty( $author ) ) { ?>
                <a class="text-orange-900" href="<?php echo $author_link;?>"><?php echo $author_title; ?></a>
            <?php } ?>
        </div>
        <h3 class="font-bold text-heading2 uppercase text-gray-900 mb-1">
            <a href="<?php echo $link;?>">
	            <?php the_title(); ?>
            </a>
        </h3>
        <p class="font-regular mb-3 text-gray-800 text-btn md:text-body">
	        <?php echo $excerpt; ?>
        </p>
        <div class="item-link">
            <a href="<?php echo $link;?>" class="font-medium left-side-right-btn-orange text-orange-900 hover:text-orange-500 text-btn text-shadow">Read more</a>
        </div>
    </div>
</div>
