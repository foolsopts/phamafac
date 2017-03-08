<div class="ajax-page" style="display:inline-block;width:100%;">
    <div class="ajax-content">
        <div class="product_block">
            <input type="hidden" class="module-id" value="{$module_data[$module_name]["id"]}">
            <input type="hidden" class="total_p" value="{$module_data[$module_name]["total_p"]}">
            <input type="hidden" class="current_p" value="{$module_data[$module_name]["current_p"]}">
            {$i = 0}
            {$j = 0}
            <pre class="hide">
            {$content|@print_r}
          </pre>
			{if $content.product|@count gt 8}
        {foreach $content.product as $val}
          {if !empty($val->product_name)}
          <div class="col-sm-4 col-xs-6">
            <div class="product_thumb">
              <button class="btn btn-xs btn-cart"><i class="fa fa-shopping-cart"></i> หยิบเลย</button>
              <div class="thumb_top">
                <div class="hover ehover1">
                  <img class="img-responsive" src="{$val->image_url}">
                  <div class="overlay">
                    <button class="info" data-toggle="modal" data-target="#modal1">DETAIL</button>
                  </div>
                </div>
              </div>
              <div class="thumb_bottom text-center">
                <span class="p_name"><strong>{$val->product_name}</strong></span>
                <span class="p_des h-sm-60 h-md-40 hidden-xs"><small>{{$val->product_description|stripcslashes}|truncate:50:"...":true}</small></span>
                <span class="p_price text-danger">฿ {$val->price_default|number_format:2:".":","}</span>
              </div>
            </div>
          </div>
          {/if}
        {/foreach}
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
<style>
.text-red{
  /*  color: #0b7707!important;*/

  }
</style>
