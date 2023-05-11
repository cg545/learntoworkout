<div class="container">
  <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <svg class="bi me-2" width="40" height="32">
        <use xlink:href="#bootstrap" />
      </svg>
      <span class="fs-4">Learn To Work Out</span>
    </a>

    <ul class="nav nav-underline">
      <li class="nav-item"><a href="/" class="<?php echo $active_page_home; ?>" aria-current="page">Home</a></li>

      <?php if (is_user_logged_in()) { ?>
        <li class="nav-item"><a href="/submit" class="<?php echo $active_page_submit; ?>">Submit</a></li>
      <?php } ?>

      <?php if (is_user_logged_in() && $is_admin) { ?>
        <li class="nav-item"><a href="/adminpanel" class="<?php echo $active_page_admin; ?>">Admin Panel</a></li>
      <?php } ?>

      <?php if (!is_user_logged_in()) { ?>
        <li class="nav-item"><a href="/login" class="<?php echo $active_page_login; ?>">Login</a></li>
      <?php } ?>

      <?php if (is_user_logged_in()) { ?>
        <li class="nav-item"><a href="<?php echo logout_url(); ?>" class="nav-link">Logout</a></li>
      <?php } ?>

    </ul>
  </header>
</div>
