<style>
   /* Styles for the slider container */
   /*.slider-container {*/
   /*width: 100%;*/
   /*overflow: hidden;*/
   /*position: relative;*/
   /*margin-left: 3% !important;*/
   
   /*}*/
   /* Styles for the big image */
   /*.slider-image {*/
   /*width: 88%;*/
   /* height: auto;*/
   /* display: block;*/
   /*}*/

</style>

<div class="swiper-slide">
    <a href="{{ asset($image_array) }}" class="popup-link">
        <img class="img-fluid w-100" src="{{ asset($image_array) }}" alt="Product variation image">
    </a>
</div>

