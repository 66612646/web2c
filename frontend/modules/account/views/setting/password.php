<div class="mod-body">
	<div class="security">
		<form class="form-horizontal" action="https://www.wegene.com/account/ajax/modify_password/" method="post" id="setting_form">
			<div class="form-group">
				<label class="control-label" for="input-password-old">当前密码</label>
				<div class="row">
					<div class="col-lg-12">
						<input type="password" class="form-control" id="input-password-old" name="old_password" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" for="input-password-new">新的密码</label>
				<div class="row">
					<div class="col-lg-12">
					    <input type="password" class="form-control" id="input-password-new" name="password" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label">密码强度</label>
				<div class="row">
					<div class="col-lg-12">
						<div class="password-strength">
							<span></span>
							<b class="hide"></b>
						</div>
					</div>
				</div>
			</div> 
			<div class="form-group">
				<label class="control-label" for="input-password-re-new">确认密码</label>
				<div class="row">
					<div class="col-lg-12">
					    <input type="password" class="form-control" id="input-password-re-new" name="re_password" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<a href="javascript:;" class="btn btn-large btn-primary btn-block" onclick="AWS.ajax_post($('#setting_form'));">保存</a>
			</div>   
		</form>
	</div>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>