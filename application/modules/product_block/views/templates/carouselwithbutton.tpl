<style>
    ._carouse {
        position: absolute;
        width: 68px;
        right: 20px;
        /* height: 60px; */
        z-index: 40;
        cursor: pointer;
        margin-top: 5px;
    }

    ._carousel-button-prev {
        /*background-image: url("{$BASEURL}assets/modules/product_block/img/pre_before.png");*/
        float: left;
        height: 30px;
        width: 30px;
        -moz-background-size: 30px 30px;
        -webkit-background-size: 30px 30px;
        background-size: 30px 30px;
        background-position: center;
        background-repeat: no-repeat;
    }

    ._carousel-button-next {
        /*background-image: url("{$BASEURL}assets/modules/product_block/img/next_before.png");*/
        float: right;
        height: 30px;
        width: 30px;
        -moz-background-size: 30px 30px;
        -webkit-background-size: 30px 30px;
        background-size: 30px 30px;
        background-position: center;
        background-repeat: no-repeat;
    }

    ._carousel-button-next:hover {
        /*background-image: url("{$BASEURL}assets/modules/product_block/img/next_after.png");*/
    }

    ._carousel-button-prev:hover {
        /*background-image: url("{$BASEURL}assets/modules/product_block/img/pre_after.png");*/
    }

    .swiper-wrapper {
        /*border: 2px solid gainsboro;*/
    }

    .thumb-box-wrap {
        border-image: url("{$BASEURL}themes/assets/img/header/bg.png") 12 round;
    }

    .thumb_bottom :after {
        /*background: url({$smarty.const.ROOTURL}assets/img/icon/4.png)no-repeat;
  background: url({$smarty.const.ROOTURL}assets/img/icon/4.png)repeat-x 0 0;*/
        background: url({$smarty.const.ROOTURL}assets/img/icon/4.png)no-repeat center top;
    }

</style>
<div class="ajax-page" style="display:inline-block;width:100%; background-color: #fff;">
    <div class="ajax-content">
        <div class="product_block">
            <input type="hidden" class="module-id" value="{$content[" id "]}">
            <input type="hidden" class="total_p" value="{$content[" total_p "]}">
            <input type="hidden" class="current_p" value="{$content[" current_p "]}">
            <div class="col-xs-12">
                {if $content|@count gt 8}
                <div class="swiper-container my_carousel _carousel" style="">
                    <div class="_carouse">
                        <div class="_carousel-button-prev"></div>
                        <div class="_carousel-button-next"></div>

                    </div>
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper" style="margin-top: 35px;">
                        <!-- Slides -->
                        {foreach $content as $val} {if !empty($val->product_name)}
                        <div class="swiper-slide">
                            <div class="product_thumb _product_block" product-id="{$val->product_no}" style="max-width: 280px;margin: auto;">
                                <span class="product_status" style="min-height:37.22px;">
                        {if $val->is_new === "new"}
                          <img class="img-responsive swing" src="{$ASSET}img/icon/new.png">
                        {/if}
                        </span>
                                <button class="btn btn-xs btn-cart"><i class="fa fa-shopping-cart"></i> หยิบเลย</button>
                                <div class="thumb_top">
                                    <img class="img-responsive" src="{$val->image_url}">
                                </div>
                                <div class="thumb_bottom text-center">
                                    <div class="p_title hide" data-toggle="tooltip" data-placement="top" title="{$val->product_name}"><span class="p_name vmedium"><a href="{$BASEURL}product/detail/{$val->product_no}/{$val->friendly}.html">{$val->product_name}</a></span></div>
                                    <span class="p_name p_title" data-toggle="tooltip" title="{$val->product_name}"><strong>{$val->product_name}</strong></span>
                                    <span class="p_des hidden-xs" >xxxxxxxxxxxx xxxxxxxxx xxxxxxxx xxxxxxx xxxx xxxxxxx</span>
                                    <span class="p_price text-danger hide">฿ 50,000</span>
                                    <span class="p_price text-danger " style="{if $val->price_prepare === $val->price_default}display:none;{/if} color: black;text-decoration: line-through;padding-left: 10px;font-size:small;">{$val->price_prepare|number_format:2:".":","}  ฿</span>
                                    <span class="p_price">{$val->price_default|number_format:2:".":","}  ฿ </span>
                                    <div style="float:left; width:100% ;padding-bottom: 5px;" class="p_price hide text-center{if $val->price_prepare === $val->price_default}{/if}">
                                        <span class="text-danger " style="{if $val->price_prepare === $val->price_default}display:none;{/if} color: black;text-decoration: line-through;padding-left: 10px;font-size:small;">{$val->price_prepare|number_format:2:".":","}  ฿</span>
                                        <span class="">{$val->price_default|number_format:2:".":","}  ฿ </span>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail _product_block hide" product-id="{$val->product_no}" style="padding:0 15px;">
                                <span class="product_status" style="min-height:37.22px;">
                            {if $val->is_new === "new"}
                              <img class="img-responsive swing" src="{$ASSET}img/icon/new.png">
                            {/if}
                            </span>
                                <div class="thumb-box-wrap tp_detail" style="cursor: pointer;">
                                    <div class="signal hide"></div>
                                    <div class="album_set" data-original="{$val->image_url}" style="background-image:url({$val->image_url});padding-top:85%;"> </div>
                                </div>
                                <div class="detail_box">
                                    <div class="p_title" data-toggle="tooltip" data-placement="top" title="{$val->product_name}"><span class="p_name vmedium"><a href="{$BASEURL}product/detail/{$val->product_no}/{$val->friendly}.html">{$val->product_name}</a></span></div>
                                    <div style="float:left; width:100% ;padding-bottom: 5px;" class="p_price   text-center{if $val->price_prepare === $val->price_default}{/if}">
                                        <span class="" style="{if $val->price_prepare === $val->price_default}display:none;{/if} color: black;text-decoration: line-through;padding-left: 10px;font-size:small;">{$val->price_prepare|number_format:2:".":","}  ฿</span>
                                        <span class="">{$val->price_default|number_format:2:".":","}  ฿ </span>
                                    </div>
                                    <br>
                                    <div style="float:left; width:100%;background-color: #000000;" class="text-center">
                                        <span style="color:white;line-height: 30px;">เปรียบเทียบสินค้า</span>
                                        <div class="input-group _product_block" product-id="{$val->product_no}" style="float:right;">
                                            <div class="_swap" style="float: right;">
                                                <img src="{$ASSET}img/icon/shopping/3.png" data-img="4.png" style="height: 30px; ">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {/if} {/foreach}
                    </div>
                    <div class="swiper-button-next _carousel-button-next{$content["column"]}"></div>
                    <div class="swiper-button-prev _carousel-button-prev{$content["column"]}"></div>
                </div>
                {else}
                <hgroup style="text-align: center;margin:20px 0;">
                    <div class="Tm" id="no_product" style="padding: 20px;">
                        <p class="text-nopro" style="text-align: center;color:#CCC;margin-top: 10px;font-size: 2em;"><span style=""><i class="fa fa-exclamation-triangle"></i></span><span style="margin-left: 20px;">Comming Soon..</span></p>
                    </div>
                </hgroup>
                {/if}

            </div>

        </div>

    </div>
</div>
{if $content["pagination"] !== 0}
<div class="row">
    <section class="content text-center" style="min-height:0;">
        <div class="page-point page-top" style="text-align: center;">
            <ul id="pagination" class="pagination-sm">
            </ul>
        </div>
    </section>
</div>
{/if}
<script>

    var carousel_col = {$content["column"]};
</script>
