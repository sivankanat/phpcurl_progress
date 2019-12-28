$(document).ready(function () {

  $("input[name=curl]").click(function () {
    $(".res").html("");
    $(".count").text("0%");
    $(".pinner").css({
      "width": "0%",
    })
    interval = setInterval(function () {
      $.get("prog.txt", function (get) {
        $(".count").text(get + "%");
        $(".pinner").animate({
          "width": parseInt(get) + "%",
        })
      });
    }, 1000);
    val = $("input[name=url]").val();
    $.ajax({
      url: "curl.php",
      data: { url: val },
      method: "POST",
      success: function (res) {

        setTimeout(function () {
          $(".res").html(res);
          if (res == "done.") {
            clearInterval(interval);
          }
        }, 3000)
      }
    })

  });

})



