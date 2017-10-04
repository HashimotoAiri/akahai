// JavaScript Document
$.validator.addMethod("one", function(value, element, origin) {
  return origin != value;
}, "エラーメッセージ");

$(function() {

  $(document).ready(function(){
    $("#form").validate({
      rules : {
        name: {
          required: true
        },
        name_kana: {
          required: true
        },
        email: {
          required: true
        },
        email_confirm: {
          required: true,
          equalTo: "#email"
        },
        tel: {
          required: false,
          number: true,
          maxlength: 11,
          minlength: 9
        },
        agree: {
          required: true
        },
        one: {
          required: false
        }
      },
      messages: {
        name: {
          required: "必須項目です"
        },
        name_kana: {
          required: "必須項目です"
        },
        tel: {
          required: "必須項目です",
          number: "有効な数字を入力してください",
          maxlength: "11桁以下でご入力ください",
          minlength: "9桁以上でご入力ください"
        },
        email: {
          required: "メールアドレスを入力してください"
        },
        email_confirm: {
          required: "確認用のメールアドレスを入力してください",
          equalTo: "メールアドレスが一致しません"
        },
        agree: {
          required: "利用規約に同意してください"
        },
        one: {
          required: "選択してください"
        }
      },
      errorClass: "error",
      errorElement: "span"
    });
  });

  /*$("form").submit(function(){
    if($(":input[name='radio1']:checked").size()==0){
      if($(":input[name='radio1']").parent().children(".error").length){
        return false;
      } else {
        $(":input[name='radio1']").parent().append("<p class='error'>選択してください</p>");
        return false;
      }
    } else {
      $(":input[name='radio1']").parent().children(".error").remove();
    };
  });*/


});//jquery
