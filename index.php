<?php
 
/**
 * Index Template
 * 
 * @package Developer_Starter
 */

get_header();
?>

<div class="dst-content">
    <div class="dst-container">
        
        <?php if (have_posts()): ?>
            
            <div class="dst-posts">
                <?php while (have_posts()): the_post(); ?>
                    
                    <article <?php post_class('dst-post-card'); ?>>
                        
                        <?php if (has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>" class="dst-post-card__image">
                            <?php the_post_thumbnail('dst-card'); ?>
                        </a>
                        <?php endif; ?>
                        
                        <div class="dst-post-card__content">
                            <h2 class="dst-post-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="dst-post-card__meta">
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                            </div>
                            
                            <div class="dst-post-card__excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="dst-btn dst-btn--outline">
                                ادامه مطلب
                            </a>
                        </div>
                        
                    </article>
                    
                <?php endwhile; ?>
            </div>
            
            <div class="dst-pagination">
                <?php
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => 'قبلی',
                    'next_text' => 'بعدی',
                ]);
                ?>
            </div>
            
        <?php else: ?>
            
            <div class="dst-no-posts">
                <p>محتوایی یافت نشد.</p>
            </div>
            
        <?php endif; ?>
        
    </div>
</div>

<?php
get_footer();
