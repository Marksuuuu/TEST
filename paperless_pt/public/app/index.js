$(document).ready(function () {
  var uploadListTbl;
  var Toast;
  var myDropzone;
  var checkedValues = [];
  var emp = localStorage.getItem('employee_id_no');
  var fname = localStorage.getItem('fullname');

 
  dropzoneUpload(emp,fname);
  Swalmixin();
  filterYear();


  $("#uploadListTbl tbody").on("change", ".updateCheckbox", function () {
    checkedValues = [];
    uploadListTbl.$(".updateCheckbox:checked").each(function () {
      checkedValues.push($(this).attr("data-id"));
   
    });
    disabledDelete()
  });

  $("#allchecked").click(function () {
    checkedValues = [];
    $("input:checkbox")
    .not(this)
    .prop("checked", this.checked);

    $(".updateCheckbox:checked")
      .not(this)
      .each(function () { 
        checkedValues.push($(this).attr("data-id"));
    });
    disabledDelete()

  });



  $("#filterYear").on("click",".dropdown-item", function(){
    var year = $(this).attr("data-year")
    displayUploadListTbl(year);
  })


  $("#deleteUploadBtn").on('click', function(){

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "ajax/reference_docs/deleteFile.php",
          data: {
            checkedValues: checkedValues,
            emp:emp,
            fname:fname
          },
          dataType: "json",
          beforeSend: function (xhr) {
            if (
              checkedValues === undefined ||
              checkedValues.length == 0
            ) {
              xhr.abort();
              Toast.fire({
                icon: "info",
                title: "Please check first!",
              });
            }
          },
          success: function (response) {
            Toast.fire({
              icon: "success",
              title: "files were successfully removed!",
            });
          },
          error: function (jqXHR, exception) {
            var msg = "";
            if (jqXHR.status === 0) {
              msg = "Not connect.\n Verify Network.";
            } else if (jqXHR.status == 404) {
              msg = "Requested page not found. [404]";
            } else if (jqXHR.status == 500) {
              msg = "Internal Server Error [500].";
            } else if (exception === "parsererror") {
              msg = "Requested JSON parse failed.";
            } else if (exception === "timeout") {
              msg = "Time out error.";
            } else if (exception === "abort") {
              msg = "Ajax request aborted.";
            } else {
              msg = "Uncaught Error.\n" + jqXHR.responseText;
            }
            Toast.fire({
              icon: "error",
              title: msg,
            });
          },
          complete: function () {
            uploadListTbl.ajax.reload();
          },
        });
      }
    });
  })

  function filterYear(){
    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var filterbtn = "";

    for (var index = 2021; index <= year; index++) {
    
      filterbtn += '<li><a class="dropdown-item" role="button" data-year="'+index+'">'+index+'</a></li>'
    }
    var lessYear = index - 1;
    displayUploadListTbl(lessYear);
    $("#filterYear").html(filterbtn);
  }

  function disabledDelete(){
    if (checkedValues === undefined ||checkedValues.length == 0 ) {

      $("#deleteUploadBtn").attr("disabled","disabled");
      
    }else{
      $("#deleteUploadBtn").removeAttr("disabled");

    }
  }

  function dropzoneUpload(emp,fname) {

    myDropzone = new Dropzone("#uploadFile", {
      url: "ajax/reference_docs/upload.php",
      paramName: "file",
      maxFiles: 10,
      maxFilesize: 5,
      addRemoveLinks: true,
      acceptedFiles: ".pdf",
      autoProcessQueue: false,
      init: function() {
        var submitButton = document.querySelector("#uploadSubmit")
        var $this = this
        submitButton.addEventListener("click", function() {
          $this.processQueue(); 
        });
      }
    });
    myDropzone.on('sending', function (file, xhr, formData) {
  
      formData.append('emp', emp);
      formData.append('fname', fname);
   });
    myDropzone.on("success", function(file, response) {
      myDropzone.options.autoProcessQueue = true; 
      Toast.fire({
        icon: "success",
        title: "Upload file success!",
      });
      uploadListTbl.ajax.reload()
    
      myDropzone.removeFile(file);
    });

    return myDropzone;
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


  function displayUploadListTbl(lessYear) {
    $("#uploadListTbl").DataTable().destroy();

    uploadListTbl = $("#uploadListTbl").DataTable({
      ajax: {
        url: "ajax/reference_docs/displayList.php",
        data: {
          lessYear:lessYear
        }
      },
      ordering: false,
      createdRow: function (row, data, dataIndex) {
        $(row).attr("id", data.id);
      },
      columns: [
        {
          data: null,
          className: "text-center",
          render: function (row) {
            return (
              '<input type="checkbox" class="form-check-input updateCheckbox pointer" data-id="' +
              row.id +
              '">'
            );
          },
        },
        { data: "id", className: "text-center" },
        { data: "filename" },
        { data: "added_on", className: "text-center" },
        { data: "added_by", className: "text-center" },
        {
          data: null,
          className: "text-center",
          render: function (row) {
            return (
              '<a class="btn btn-secondary m-1" href="pdf/' +
              row.filename +
              '"  target="_blank" >View</a>'
            );
          },
        },
      ],
    });

    return uploadListTbl;
  }
});

