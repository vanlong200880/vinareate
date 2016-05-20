jQuery(document).ready(function($){
  $(".list-search > li").on('click', function(){
    $(".list-search li").removeClass('active');
    $(this).addClass('active');
    var key = $(this).attr('data-key');
    $("#slider-home").removeClass().addClass(key);
  });
  
//  $("#list-home-news").owlCarousel({
//      items : 4,
//      itemsDesktop: [1400, 4],
//      itemsDesktopSmall: [1100, 3],
//      itemsTablet: [767, 3],
//      itemsMobile: [500, 2],
//      
//      autoPlay: 6000,
//      navigation : true,
//      slideSpeed : 300,
//      paginationSpeed : 400,
//      pagination : false,
//      paginationNumbers: false,
//          //singleItem : true,
//      navigationText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
//      rewindNav : true,
//      stopOnHover : true,
//  });
//  $("#list-home-news-1").owlCarousel({
//      items : 4,
//      itemsDesktop: [1400, 4],
//      itemsDesktopSmall: [1100, 3],
//      itemsTablet: [767, 3],
//      itemsMobile: [500, 2],
//      
//      autoPlay: 18000,
//      navigation : true,
//      slideSpeed : 300,
//      paginationSpeed : 400,
//      pagination : false,
//      paginationNumbers: false,
//          //singleItem : true,
//      navigationText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
//      rewindNav : true,
//      stopOnHover : true,
//  });
//  $("#list-home-news-2").owlCarousel({
//      items : 4,
//      itemsDesktop: [1400, 4],
//      itemsDesktopSmall: [1100, 3],
//      itemsTablet: [767, 3],
//      itemsMobile: [500, 2],
//      
//      autoPlay: 10000,
//      navigation : true,
//      slideSpeed : 300,
//      paginationSpeed : 400,
//      pagination : false,
//      paginationNumbers: false,
//          //singleItem : true,
//      navigationText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
//      rewindNav : true,
//      stopOnHover : true,
//  });
  // menu search
  $(".menu-search ul>li.search-list-item").on('click', function(e){
      $(".menu-search li.search-list-item").removeClass('selected');
      $(this).addClass('selected');
      e.stopPropagation();
  });
  $(document).click(function(e) {
    if (!$(e.target).is('.search-list-item, .search-list-item *')) {
      $(".menu-search li.search-list-item").removeClass('selected');
    }
  });

$('li :checkbox').on('click', function () {
    var $chk = $(this),
        $li = $chk.closest('li'),
        $ul, $value = '', $parent;
        $value = $(this).val();
        console.log($value);
    if ($li.has('ul')) {
        $li.find(':checkbox').not(this).prop('checked', this.checked);
        console.log($li);
    }
//    do {
//        $ul = $li.parent();
//        
//        $parent = $ul.siblings(':checkbox');
//        if ($chk.is(':checked')) {
//            $parent.prop('checked', $ul.has(':checkbox:not(:checked)').length == 0)
//        } else {
//            $parent.prop('checked', false)
//        }
//        $chk = $parent;
//        $li = $chk.closest('li');
//        console.log($li);
//    } while ($ul.is(':not(.someclass)'));
});

});