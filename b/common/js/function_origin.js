$(function(){
  $(".func-question, .func-result").hide();
  $(".question-01").show();

  $(".func-a-01-t").click(function(){
    $(".func-question").fadeOut();
    $(".question-02").fadeIn();
    return false;
  })
  $(".func-a-02-t").click(function(){
    $(".func-question").fadeOut();
    $(".salary-result").fadeIn("normal",function(){
      setTimeout(function(){
        $('.odometer').html(500000);
      }, 300);
    });
    return false;
  })
});
