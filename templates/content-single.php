<article <?php post_class(); ?> >
    <header>
      <h1 class="entry-title blog-article"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>

      <div class="article-info">
        <?php 
          $categories = get_the_category();
          $categorieOutput = '';

          foreach ($categories as $i => $category) {
            if($i != 0){
              $categorieOutput .= ', ';
            }
            $categorieOutput .= $category->name;
          }
       
          echo __('Publié par','cadre21').' '.get_the_author().' le '.get_the_date('d F Y');

          if($categorieOutput != ''){
            echo ' dans '.$categorieOutput;
          }
        ?> 
      </div>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>