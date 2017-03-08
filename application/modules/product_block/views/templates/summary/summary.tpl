{$data = $module_data[$module_name]}
<div class="col-md-12">
    <hgroup style="text-align: center;margin:20px 0;">
        {if $data["totalCart"] > "0"}
        <h2 class="have-pro" style="display: inline-block;margin-top: 0;">ตะกร้าสินค้าของท่าน : <span class="text-red total_sum">{$data["totalCart"]}</span> ชิ้น</h2>
        <h4 class="have-pro" style="display: inline-block; margin-left:10px;margin-top: 0;">จากรายการสินค้าทั้งหมด <strong><span class="total_cat">{$data["count_cat"]}</span></strong> ประเภท</h4> {/if}
        <div class="Tm" id="no_product" style="padding:20px;{if $data["totalCart"] > 0}display:none;{/if}">
            <p class="text-nopro" style="text-align: center;color:#CCC;margin-top: 10px;font-size: 2em;"><span style=""><i class="fa fa-exclamation-triangle"></i></span><span style="margin-left: 20px;">ไม่พบสินค้าในตระกร้า</span></p>
        </div>
    </hgroup>
</div>
<div class="col-md-12">
    {if $data["totalCart"] > "0"}
    <div class="box box-solid have-pro">
        <div class="box-body">
            <table class="table no-margin responsive">
                <thead>
                    <tr>
                        <th class="fixed-width-xs text-center"><strong class="Tmb">รูปสินค้า</strong></th>
                        <th class="text-center"><strong class="Tmb">รายการสินค้า</strong></th>
                        <th class="fixed-width-md text-right hidden-xs"><strong class="Tmb">ราคา / ชิ้น</strong></th>
                        <th class="fixed-width-xs text-center"><strong class="Tmb">จำนวน</strong></th>
                        <th class="fixed-width-md text-right"><strong class="Tmb">มูลค่า(รวม)</strong></th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $data["p_list"] as $list}
                    <tr id="{$list->product_no}">
                        <td class="text-center nopadding" style="position:relative;">
                          <div class="_loadThumb signal"></div>
                          <div class="album_set lazy" data-original="{$list->product_image[0]}" style="background-image:url();padding-top: 70%;"> </div>
                        </td>
                        <td class="Tmb">
                          <div class="sp_name"><a class="product_link text-red" href="{$BASEURL}product/detail/{$list->product_no}/{$list->friendly}.html">{$list->product_name}</a></div>
                          <div class="sp_code">รหัสสินค้า : {$list->product_code}</div>
                          <a class="cart_del" href="javascript:void(0);"><small><i class="fa fa-times"></i> ลบรายการสินค้า</small></a>
                        </td>
                        <td class="text-right hidden-xs hidden-sp Tsm"><span class="Tm">฿</span><span class="q" price-data="{$list->price_default}">{{$list->price_default}|number_format:2:".":","}</span></td>
                        <td class="text-center"><span class="pull-left visible-xs visible-sp">จำนวน :</span><span class="pull-right visible-xs visible-sp">: ชิ้น</span>
                            <input type="number" class="form-control quantity text-center input-sm Tm" value="{$list->q}" min="1" style="max-width:70px;margin:auto; line-height: 0px;height:35px;background-color:gainsboro;">
                        </td>
                        <td class="text-right Tsm"><span class="pull-left visible-xs">รวม :</span><strong><span class="Tm">฿</span><span class="price">{{$list->tamount}|number_format:2:".":","}</span></strong></td>
                    </tr>
                    {/foreach}

                </tbody>

            </table>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-md-12 text-right">
                    <h4><span class="Tm">มูลค่าสินค้า</span><strong><span class="sum_total " style="padding-left:15px;">{$data["sum_amount"]|number_format:2:".":","}</span> <span class="Tm ">บาท</span></strong><br>
													</h4><span class="Ts ">(ราคานี้ยังไม่รวมค่าส่ง)</span>
                </div>
                <div class="col-xs-12">
                    <a href="{$BASEURL}checkout">
                        <button class="btn btn-block btn-black pull-right" style="max-width:200px;min-width:100px;margin-left:auto;"><span class="Tm">สั่งซื้อสินค้า</span> <i class="fa fa-chevron-right"></i></button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {/if}
</div>
