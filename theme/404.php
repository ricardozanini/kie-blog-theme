<?php get_header(); ?>
  <div class="row error-page">
      <main class="column" role="main">
        <h1>404</h1>
        <p>
          Oops! That page can't be found.
          <br />
          <a href="<?= get_home_url() ?>">
            Try to find something interesting <b>here.</b>
          </a>
        </p>
      </main>
  </div>
<?php get_footer(); ?>
