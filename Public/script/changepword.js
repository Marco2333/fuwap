$(document).ready(function(){

	$(".row-check").hide();

	$(".main .row-6 #main-submit").click(function(){
		var info = {
			'phone':$("#cPhone").val(),
			'verify':$("#cVerify").val(),
			'pVerify':$("#cPVerify").val(),
			'pword':$("#cPWord").val()
		};
		if (info['phone'] == "") {
			checkShow(".row-check","手机号不能为空！");
			return;
		}

		if (info['verify'] == "") {
			checkShow(".row-check","验证码不能为空！");
			return;
		}

		if (info['pVerify'] == "") {
			checkShow(".row-check","手机验证码不能为空！");
			return;
		}

		if (info['pword'] == "") {
			checkShow(".row-check","输入的密码不能为空！");
			return;
		}

		if (info['pword'] != $("#cConfirm").val()) {
			checkShow(".row-check","两次输入的密码不一致！");
			return;
		}

		$.ajax({
			type:"post",
			url:"../../Home/Person/saveNewPWord",
			data:info,
			async:true,
			success:function(result){
				if (result['result'] != 0) {
					checkShow(".row-check",result['message']);
					setTimeout(function(){
						window.location.href="../../Home/Login/personHomePage";
					},2600);
				}
				else {
					checkShow(".row-check",result['message']);
				}
			}
		});

	});
})

function checkShow(id,string){
	$(id).html(string).show(300);
		setTimeout(function(){
			$(id).hide(300);
	},2000);
}