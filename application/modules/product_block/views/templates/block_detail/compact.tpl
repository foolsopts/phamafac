<style>
#quickView input{
	background: gainsboro;
	border:none;
	padding:5px;
}
.fit-input{
	background: gainsboro;
	border: none;
	padding: 3px 0;
	width: 100%;
}
#quickView .alert{
	padding:5px;
}

</style>
<div class="modal fade" id="quickView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index:1041;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="Tb">×</span></button>
				<h3 class="modal-title  " id="myModalLabel"></h3>
			</div>
			<div class="_cart_control compact modal-body">
				<div class="row">
					<!-- img product -->
					<div id="div-img" class="col-md-6 col-sm-6" style="margin-top:10px;margin: auto;">
						<div class="reload">  </div>
						<h4 class="text-center hide">คลิกภาพเพื่อขยาย <i class="fa fa-search-plus" aria-hidden="true"></i></h4>
					</div>
					<!-- option form -->
					<div id="div-option" class="col-md-6 col-sm-6">
						<div style="margin-top:10px;"><span class="div-option-head">รหัสสินค้า <span>/ Product ID</span></span> </div>
						<div style="width:100%"><span class=" idPro auto-line reload"></span></div>
						<div style="margin-top:10px;"><span class="div-option-head">ชื่อ <span>/ Product name</span></span> </div>
						<p><span class="_productname">-</span></p>
						<p>ยี่ห้อ / Brand<br/><span class="_brand">-</span></p>
						<p>รุ่น / Model<br/><span class="_model">-</span></p>
						<div style="margin-top:10px;"><span class="div-option-head">ขนาด / Size - สี / Color - ราคา / Price</span> </div>
						<div>
							<span class="box3">

							</span>
							<div class="option-box" style="display: block;">
								<div style="margin-top:10px;"><span class="div-option-head">จำนวนชิ้น <span>/ Number of pieces</span></span> </div>
								<div>
									<div class="row">
										<div class="col-md-12">
											<input class="numberPieces form-control" type="number" min="1" value="1" style="max-width:160px;float:left;">
											<button type="button" class="btn add_product btn-black pull-right">Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<div style="margin-top:10px;border-top: 2px dashed grey;padding-top:5px;"><span class="div-option-head">ราคารวม <span>/ Total Price</span></span> </div>
							<div><span class="qt Tbold color-danger auto-line reload" style="font-weight:bold;"></span><span class=" Tbold auto-line" style="margin-left:30px;">บาท / ฿</span></div>
							<div class="pre-box" style="margin: 15px 0px; display: none;">
								<div class="alert alert-danger" style="background-color: #FBEAEA;color:#e00;">
									<p><span>Out of stock</span></p>
									<p><span>Contact: {$module_data[$module_name]["contact_tel"]}</span></p>
								</div>
							</div>
						</div>
						<!-- <hr>
							<button type="button" class="btn add btn-primary Tm Tbold">Add to Cart</button>-->
					</div>
				</div>
			</div>
			<div class="modal-footer" style="display:table;width:100%;">
				<span class="quick_view_info" style="verticle-align:middle;float:right;">
					<a href="">
						<h4 class="text-black" style="font-weight:bold; "><i class="fa fa-info" aria-hidden="true"></i> รายละเอียด / Specification</h4>
					</a>
				</span>
			</div>
		</div>
	</div>
</div>
