<style>
	.fit-input {
		background: gainsboro;
		border: none;
		padding: 3px 0;
		width: 100%;
	}
	input {
		background-color: gainsboro!important;
		border: none;
		padding: 5px;
	}
	._pdetail {
		white-space: pre-wrap;
	}
</style>
<div class="col-md-12">
	<div class="_cart_control full box box-solid">
		<div class="box-body">
			<!-- img product -->
			<div id="div-img" class="col-md-6 col-sm-6" style="margin-top:10px;margin: auto;">
				<div class="reload"><div class="signal"></div></div>
				<h4 class="text-center hide">คลิกภาพเพื่อขยาย <i class="fa fa-search-plus" aria-hidden="true"></i></h4>
			</div>
			<!-- option form -->
			<div id="div-option" class="col-md-6 col-sm-6">
				<div style="margin-top:10px;"><span class="div-option-head">รหัสสินค้า <span>/ Product ID</span></span>
				</div>
				<div style="width:100%;margin-bottom:10px;"><span class=" idPro auto-line reload"></span></div>
				<p>ชื่อ / Product name<br/><span class="_productname">-</span></p>
				<p>ยี่ห้อ / Brand<br/><span class="_brand">-</span></p>
				<p>รุ่น / Model<br/><span class="_model">-</span></p>				
				<div style="margin-top:10px;"><span class="div-option-head">ขนาด / Size - สี / Color - ราคา / Price</span> </div>
				<div>
					<span class="box3">
                      <select class="product_option fit-input form-control">
												{foreach $module_data[$module_name]["select_list"] as $val}
												<option value="{$val->product_no}" {if $val->product_no === $module_data[$module_name]["detail"]["product"][0]->product_no}selected{/if}>
													{$val->product_size} | {$val->product_color} | {$val->price_default}
												</option>
												{/foreach}
                      </select>
                    </span>
					<div class="option-box" style="display: block;">
						<div style="margin-top:10px;"><span class="div-option-head">จำนวนชิ้น <span>/ Number of pieces</span></span>
						</div>
						<div>
							<div class="row">
								<div class="col-md-12">
									<input class="numberPieces form-control" type="number" min="1" value="1" style="max-width:200px;float:left;">
									<button type="button" class="btn add_product btn-danger Tbold pull-right">Add to Cart</button>
								</div>
							</div>
						</div>
					</div>
					<div style="margin-top:10px;border-top: 2px dashed grey;padding-top:5px;"><span class="div-option-head">ราคารวม <span>/ Total Price</span></span>
					</div>
					<div><span class="qt Tbold color-danger auto-line reload" style="font-weight:bold;"></span><span class=" Tbold auto-line" style="margin-left:30px;">บาท / ฿</span></div>
					<div class="pre-box" style="margin: 15px 0px; display: none;">
						<div class="alert alert-danger" style="background-color: #FBEAEA;color:#e00;padding:5px;">
							<p><span>Out of stock</span></p>
							<p><span>Contact: {$module_data[$module_name]["contact_tel"]}</span></p>
						</div>
					</div>
				</div>
							<!-- <hr>
              <button type="button" class="btn add btn-primary Tm Tbold">Add to Cart</button>-->
			</div>
		</div>
		<div class="box-footer">
			<div class="detail reload">

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="detail-pro active text-bold"><a href="#pro_detail" aria-controls="pro_detail" role="tab" data-toggle="tab" aria-expanded="true" style="background-color:gainsboro;"><span class="text-black"  >รายละเอียดสินค้า  / Specification</span></a></li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active Tm" id="pro_detail" style="padding:20px">
						<p class="text-nodetail"><span style="margin-left: 20px; white-space: pre-wrap;"><span style=""><i class="fa fa-exclamation-triangle"></i></span> ไม่มีรายละเอียดสินค้า  / No Specification</span></p>
						<p class="_pdetail"></p>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
