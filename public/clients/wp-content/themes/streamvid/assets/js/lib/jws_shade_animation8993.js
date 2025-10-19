(function($) {
	"use strict";
$(document).ready(function(){
   	if ( $.find( ".jws-shade-yes" ).length < 1 ) {
		return;
	}
    
    $('.split-mobile').find('.shade_animation').remove();

     $(".jws-shade-yes").each(function() {
        var id = $(this).data( "id" );
           shade_script(id,$(this));
     });  

    function shade_script(id,$this) { 
        var $scope =  $this.parents('.elementor').find(".elementor-element-"+id);
        var $content = $(".shade-"+id);
        
        if($scope.find(".shade-"+id).length > 0 ) {
            return false;
        }
       
        if( $scope.find( ".elementor-background-overlay ~ .elementor-container" ).length == 0 ) {
    		$scope.prepend($content);   
    	} else {
    		$scope.find( ".elementor-background-overlay" ).after($content);
    	}	
      
        
    }
    
    $(".svg-shade-animation").each(function() {
           let $this = $(this); 
           $this.appear(function() {
                setTimeout(function() {  $this.addClass("animated") }, 1000);
           },({accY:-200}));
     }); 
});
})(jQuery);    