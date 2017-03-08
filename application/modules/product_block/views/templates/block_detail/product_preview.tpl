<style>
    .swiper-container {
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .swiper-slide {
        background-size: cover;
        background-position: center;
    }

    .gallery-top {
        height: 80%;
        width: 100%;
    }

    .gallery-thumbs {
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    .gallery-thumbs .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    .gallery-thumbs .swiper-slide-active {
        opacity: 1;
    }
    .product_preview {
      /*position: absolute;*/
      top:0;
      width:100%;
      max-height:265px;
    }
</style>
<div class="product_preview" style="visibility:hidden;">
    <!-- Swiper -->
    <div class="swiper-container _previewTop" style="margin-bottom:15px;">
        <div class="swiper-wrapper">
            {foreach $product[0]->product_image as $img}
            <div class="swiper-slide">
                <a href="{$img}" class="image-link">
                    <img class="img-responsive" src="{$img}" style="margin:auto;">
                </a>
            </div>
            {/foreach}
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next swiper-button-white hide"></div>
        <div class="swiper-button-prev swiper-button-white hide"></div>
    </div>
    {if $product[0]->product_image|@count gt 1}
    <div class="swiper-container _previewThumb">
        <div class="swiper-wrapper">
            {foreach $product[0]->product_image as $img}
            <div class="swiper-slide">
                <img class="img-responsive hide" src="{$img}" style="margin:auto;max-height:50px;">
                <div class="album_set" style="background-image:url({$img});padding-top:100%;"> </div>
            </div>
            {/foreach}
        </div>
    </div>
    {/if}
</div>
<script>

</script>
