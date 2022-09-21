jQuery(function($) {

  function scroll_to_filter_after_paginate_blog() {
      var $this = $('.stories-post'),
          scroll = $this.offset();

      $('html, body').animate({scrollTop: scroll.top }, 600);
  }

  function globerunner_ajax_pagination_blog() {
      var $pagination = $('.globerunner-ajax-pagination'),
          $link = $pagination.find('.nav-links a');

      $link.on('click', function (e) {
          e.preventDefault();

          var $this = $(this),
              cat = $this.data('term'),
              page = $this.data('page');

          $.ajax({
              url: ajax_obj.ajaxurl,
              data: {
                  'action': 'post_filter_ajax',
                  'category': cat,
                  'paged': page
              },

              success:function(data) {
                  // This outputs the result of the ajax request
                  $inner.html(data);
                  globerunner_ajax_pagination_blog();
                  scroll_to_filter_after_paginate_blog();
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
          });
      });
  }


  // Custom dropdown

  var $homeFilter = $('.stories-home-filter'),
      $homeSelect = $homeFilter.find('select'),
      $filterBtn = $('.filter-button-post'),
      $select = $filterBtn.find('select'),
      $inner = $('.post-items'),
      $option = $filterBtn.find('.sub-stories-post');

  $homeSelect.on('change', function () {
      var $this = $(this),
          link = $this.val();

      location.replace(link);
  });

  $select.on('change', function () {
      var $this = $(this),
          category = $this.val();

      $inner.empty();

      $this.hasClass('filtered');

      $.ajax({
          url: ajax_obj.ajaxurl,
          data: {
              'action': 'post_filter_ajax',
              'category': category,
          },

          success:function(data) {
              // This outputs the result of the ajax request
              $inner.html(data);
              globerunner_ajax_pagination_blog();
          },

          error: function(errorThrown){
              console.log(errorThrown);
          }
      });

  });

  $option.on('click', function () {
      var $this = $(this);

      var category = $this.data('cat-slug');

          $inner.empty();

          $.ajax({
              url: ajax_obj.ajaxurl,
              data: {
                  'action': 'post_filter_ajax',
                  'category': category,
              },

              success:function(data) {
                  // This outputs the result of the ajax request
                  $inner.html(data);
                  globerunner_ajax_pagination_blog();
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
          });

  });


});
