<style>
.thumb-box-wrap {
    border-image: url("{$BASEURL}themes/assets/img/header/bg.png") 12 round;
}
</style>
<div class="ajax-page" style="display:inline-block;width:100%;">
    <div class="ajax-content">
        <div class="product_block">
            <input type="hidden" class="module-id" value="{$module_data[$module_name]["id"]}">
            <input type="hidden" class="total_p" value="{$module_data[$module_name]["total_p"]}">
            <input type="hidden" class="current_p" value="{$module_data[$module_name]["current_p"]}">

            <div class="swiper-container my_carousel _carousel" style="margin:auto;max-width:2048px;width: 100%;">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper"  style="border-top-style: dotted;">
                    <!-- Slides -->
                    {foreach $module_data[$module_name] as $val} {if !empty($val->product_name)}
                    <div class="swiper-slide">
                        <div class="thumbnail _product_block" product-id="{$val->product_no}" style="padding:0 15px;">
                            <span class="product_status" style="min-height:37.22px;">
                            {if $val->is_new === "new"}
                              <img class="img-responsive swing" src="{$ASSET}img/icon/new.png">
                            {/if}
                            </span>
                            <div class="thumb-box-wrap tp_detail" style="cursor: pointer;">
                                <div class="signal hide"></div>
                                <div class="album_set" data-original="{$val->image_url}" style="background-image:url({$val->image_url});padding-top:85%;"> </div>
                            </div>

                            <!-- <div class="detail_box hide">
                                <div class="p_title" data-toggle="tooltip" data-placement="top" title="{$val->product_name}"><span class="p_name vmedium"><a href="{$BASEURL}product/detail/{$val->product_no}/{$val->friendly}.html">{$val->product_name}</a></span></div>
                                <div class="p_brand"><small> {$val->product_brand} {$val->product_model}</small></div>
                                <div class="p_description" style="height: 84px;overflow: hidden;"><small>
                                   {if $val->product_description ==""}
                                     -
                                   {else}
                                      {$val->product_description}
                                   {/if}
                                </small></div>
                                <div style="float:left; " class="p_price text-red"> <span class="" style="{if $val->price_prepare === $val->price_default}display:none;{/if}color: black;text-decoration: line-through;padding-left: 10px;font-size:small;">{$val->price_prepare|number_format:2:".":","}  ฿ </span> <span class="">{$val->price_default|number_format:2:".":","}  ฿ </span> </div>
                                <div class="input-group _product_block" product-id="{$val->product_no}" style="float: right;">
                                  <button type="submit" class="btn btn-flat btn-block btn-cart btn-sm bg-black"> BUY  </button>
                                </div>
                            </div> -->

                            <div class="detail_box text-center">
                                <div class="p_title" data-toggle="tooltip" data-placement="top" title="{$val->product_name}"><span class="p_name vmedium"><a href="{$BASEURL}product/detail/{$val->product_no}/{$val->friendly}.html">{$val->product_name}</a></span>{if $val->price_prepare === $val->price_default}<br><span style="font-size:small;">&nbsp;</span>{/if}</div>
                                <div style="float:left; width:100%" class="p_price text-red">
                                  <span class="" style="{if $val->price_prepare === $val->price_default}display:none;{/if}color: black;text-decoration: line-through;/*padding-left: 10px;*/font-size:small;">{$val->price_prepare|number_format:2:".":","}  ฿<br></span>
                                  <span class="">{$val->price_default|number_format:2:".":","}  ฿ </span>
                                </div>
                                <br>
                                <div style="float:left; width:100%;background-color: #000000;" class="text-center">
                                  <span style="color:white;line-height: 30px;" >เปรียบเทียบสินค้า</span>
                                  <div class="input-group _product_block" product-id="{$val->product_no}" style="float:right;">
                                    <div   class="_swap" style="float: right;">
                                      <img src="{$ASSET}img/icon/shopping/3.png" data-img="4.png"  style="height: 30px; ">
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {/if} {/foreach}
                </div>
            </div>
        </div>

    </div>
</div>
{if $module_data[$module_name]["pagination"] !== 0}
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
var carousel_col = {$module_data[$module_name]["column"]};
</script>
