$(function(){

  $(".func-question, .func-result").hide();
  $(".question-01").show();
  var status = 0;

  //設問01
  $(".func-a-01-t").click(function(){
    status = status + 1;
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-03").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-01-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-02").fadeIn("normal");
      }, 500);
    });
    return false;
  });

  //設問02
  $(".func-a-02-t").click(function(){
    status = status + 1;
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-03").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-02-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-03").fadeIn("normal");
      }, 500);
    });
    return false;
  });

  //設問03
  $(".func-a-03-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-04").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-03-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            if(status == 0) {
              $('.odometer').html(3000000);
            } else {
              $('.odometer').html(3500000);
            }
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問04
  $(".func-a-04-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-05").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-04-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(3500000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問05
  $(".func-a-05-t").click(function(){
    status = status + 5;
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-06").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-05-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-06").fadeIn("normal");
      }, 500);
    });
    return false;
  });

  //設問06
  $(".func-a-06-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-07").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-06-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            if(status >= 5) {
              $('.odometer').html(4000000);
            } else {
              $('.odometer').html(3500000);
            }
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問07
  $(".func-a-07-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-08").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-07-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(4000000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問08
  $(".func-a-08-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-09").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-08-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(4500000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問09
  $(".func-a-09-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-10").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-09-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(4500000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問09
  $(".func-a-10-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-11").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-10-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(4500000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問11
  $(".func-a-11-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-12").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-11-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(5000000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問12
  $(".func-a-12-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-13").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-12-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(5000000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問13
  $(".func-a-13-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-14").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-13-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(5000000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問14
  $(".func-a-14-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".question-15").fadeIn("normal");
      }, 500);
    });
    return false;
  });
  $(".func-a-14-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(6000000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });

  //設問15
  $(".func-a-15-t").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(6500000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });
  $(".func-a-15-f").click(function(){
    $(".func-question").fadeOut("fast",function(){
      setTimeout(function(){
        $(".salary-result").fadeIn("normal",function(){
          setTimeout(function(){
            $('.odometer').html(6000000);
          }, 500);
        });
      }, 500);
    });
    return false;
  });


});
