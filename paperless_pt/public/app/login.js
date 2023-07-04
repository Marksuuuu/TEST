$(document).ready(function () {
  var Toast;
  var alert;
  Swalmixin();
  alert()
  autoAlert();

  $("#hrisForm").validate({
    rules: {
      hrisusername: "required",
      hrispass: "required",
    },
    messages: {
      hrisusername: {
        required: "*",
      },
      hrispass: {
        required: "*",
      },
    },
    errorPlacement: function(error, element) {
      // Display error messages in corresponding labels
      if (element.attr("type") === "checkbox" || element.attr("type") === "radio") {
        error.appendTo(element.parent());
      } else {
        error.appendTo(element.siblings("label.labeltext"));
      }
    },
    submitHandler: function (form) {
      var hrisForm = $(form).serialize();
    
      fetchData("ajax/login.php", hrisForm)
      .done(function(data) {
       if(data["status"] == 1){

        
        $.each(data["storeCredentials"], function (key, value) { 
          localStorage.setItem(key,  value);
        });
       
        var url = 'http://devapps.teamglac.com/paperless_pt/index.php'
    
        window.location.href = url;
       }else{
        Toast.fire({
            icon: "warning",
            title:"Incorrect Username/Password",
        });
        var url = 'http://devapps.teamglac.com/paperless_pt/login.php?status='+data["status"]
        history.pushState(null, null, url);
       }
      })
     
    },
  });


  function autoAlert(){
    alert.fire({
      icon: 'info',
      title: 'Reminders: If you cant login please call MIS 267.'
    })
  }

  function Swalmixin() {
    Toast = Swal.mixin({
      toast: true,
      position: "top-right",
      iconColor: "white",
      customClass: {
        popup: "colored-toast",
      },
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
      },
    });

    return Toast;
  }


  function alert() {
    alert = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });

    return alert;
  }
  

  function fetchData(url, data) {
    return  $.ajax({
        type: "post",
        url: url,
        data:data,
        dataType: "json",
        beforeSend: function () {
            $("body").addClass("loading");
        },
        complete: function (){
            $("body").removeClass("loading");
        }
      })
      .done(function(response) {
        return response;
      })
      .fail(function(jqXHR,exception) {
        if (jqXHR.status === 0) {
            error = "Not connect.\n Verify Network.";
        } else if (jqXHR.status == 404) {
            error = "Requested page not found. [404]";
        } else if (jqXHR.status == 500) {
            error = "Internal Server Error [500].";
        } else if (exception === "parsererror") {
            error = "Requested JSON parse failed.";
        } else if (exception === "timeout") {
            error = "Time out error.";
        } else if (exception === "abort") {
            error = "Ajax request aborted.";
        } else {
            error = "Uncaught Error.\n" + jqXHR.responseText;
        }
        Toast.fire({
            icon: "error",
            title: error,
          });
      });
  }

  
});
