var checkedValues = [];
$(document).ready(function () {
  var Toast;
  var pageList_tbl;
  var userAccess_tbl;

  var emp = localStorage.getItem('employee_id_no');
  var fname = localStorage.getItem('fullname');


  Swalmixin()
  displayPageList()
  autoStoreArray()

  $("#userAccess_tbl").on("change", ".updateCheckbox", function () {
    checkedValues = [];

    userAccess_tbl.$(".updateCheckbox:checked").each(function () {
      checkedValues.push($(this).attr("data-id"));
    });

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

  });


  $("#userAccess_btn").on('click', function(){
    var id = $(this).attr("data-id");
 

    if(checkedValues.length === 0){
       
        Toast.fire({
            icon: "warning",
            title: "Check before you saved!",
          });
        return;
    }
    Swal.fire
    ({
       title: "Are you sure you want to continue?",
       text: "You won't be able to cancel this!",
       icon: "question",
       showCancelButton: true,
       confirmButtonColor: "#3085d6",
       cancelButtonColor: "#d33",
       confirmButtonText: "Continue!",
     })
     .then((result) => {
           if (result.isConfirmed) {
                fetchData("ajax/user_controller/accessUpdate.php", {id:id,checkedValues:checkedValues})
                .done(function(response) {
                    if(response["data"] == true){
                        Toast.fire({
                            icon: "success",
                            title: "Employee has been saved!",
                          });
                      }else{
                        Toast.fire({
                          icon: "error",
                          title: "Something went wrong!",
                        });
                      }
                })
           }
     })
  })

  $("#createPage_btn").on("click", function () {
    $("#createPage_modal").modal("toggle");
 
    $("#inputName").val("");
    $("#inputLink").val("");
    $("#inputIcon").val("");
  });


  $("#pageList_tbl").on('click','.modalUserAcccess-btn',function(){
    checkedValues = [];
    var id = $(this).attr('data-id');
    $("#userAccess_modal").modal("toggle");


    displayUserAccess(id);
  })

  $("#pageList_tbl").on('change','.checkboxStatus', function () {
      var id = $(this).attr('data-id');
      var status = $(this)[0].checked ? "active" : "deactive";

      fetchData("ajax/user_controller/changeStatusPage.php",
      {
        id:id,
        status:status
      }
      ).done(function (response) {
        if(response["data"] == "success"){
          if(status == "active"){
            Toast.fire({
                icon: "success",
                title: "STATUS : Online!",
              });
          }else{
            Toast.fire({
                icon: "error",
                title: "STATUS : Offline!",
              });
          }
        }else{
          Toast.fire({
            icon: "error",
            title: "Something went wrong!",
          });
        }
      })
     
  })

  $("#createPage_modal").on("click", "#createPage_save", function () {
    var inputName = $("#inputName").val();
    var inputLink = $("#inputLink").val();
    var inputIcon = $("#inputIcon").val();

    if(inputName == "" || inputLink == "" || inputIcon == ""){
        Toast.fire({
            icon: "warning",
            title: "Please enter value!",
        });
        return;
    }
    CreatePage(inputLink,inputName,inputIcon);
  });

  function displayUserAccess(id) {
    $("#userAccess_tbl").DataTable().destroy();

    $("#userAccess_btn").attr("data-id",id)
    userAccess_tbl = $("#userAccess_tbl").DataTable({
        ajax: {
          url: "ajax/user_controller/displayUserAccessList.php",
          data: {
            id:id
          }
        },
        columns: [
          {
            data: null,
            className: "",
            render: function (row) {


              return (
                '<input type="checkbox" class="form-check-input updateCheckbox pointer" data-id="' + row.employee_id_no +'" '+(row.checked == id ? 'checked' : '')+' >'
              );
            },
          },
          {
            data: null,
            className: "",
            render: function (row) {
              return (
                '<b><span class="badge text-bg-success fs-2 rounded-4 py-1 px-2">'+row.employee_id_no+'</span> '+row.fullname+'</b>'
              );
            },
          },
          { data: "employee_position" },
          { data: "employee_department" },
        ],
      });
  
      return userAccess_tbl;
  }

  function CreatePage(inputLink,inputName,inputIcon) {
    Swal.fire
     ({
        title: "Are you sure you want to continue?",
        text: "You won't be able to cancel this!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Continue!",
      })
      .then((result) => {
            if (result.isConfirmed) {
                fetchData("ajax/user_controller/createPage.php",
                    { 
                        link: inputLink,
                        name:inputName,
                        icon:inputIcon,
                        fname:fname,
                        emp:emp
                    }
                 )    
                .done(function(response) { 
                   var status = response["status"];        
                   if(status == "success"){
                    Toast.fire({
                      icon: "success",
                      title: "Save page successfully!",
                    });
                   }else{
                    Toast.fire({
                      icon: "error",
                      title: "Something went wrong?..",
                    });
                   }
                   $("#createPage_modal").modal("toggle");
                   pageList_tbl.ajax.reload()
                })
            }
        });
  }

  function autoStoreArray(){
    $(".updateCheckbox:checked").each(function () {
      checkedValues.push($(this).attr("data-id"));
    });
  }

  function displayPageList(){
    pageList_tbl = $("#pageList_tbl").DataTable({
      ajax: {
        url: "ajax/user_controller/displaypageList.php",
      },
      ordering: false,
      createdRow: function (row, data, dataIndex) {
        $(row).attr("id", data.id);
      },
      columns: [
        {
          data: null,
          className: "",
          render: function (row) {
            return (
              '<div class="form-check form-switch"><input class="form-check-input pointer checkboxStatus" type="checkbox" data-id="'+row.id+'" '+(row.status == 'active' ? 'checked' : '')+' data-bs-toggle="tooltip" title="Active/Deactive"></div>'
            );
          },
        },
        { data: "page_name" },
        { data: null,
          className:"text-center",
          render: function (row) {
            return (
              '<b>'+row.page_link+'.php</b>'
            );
          },
        },
        { data: null,
          className:"text-center",
          render: function (row) {
            return (
              '<i class="'+row.page_icon+' fs-4 me-2"></i>'
            );
          },
        },
        { data: "added_by", className: "text-center" },
        { data: "added_on", className: "text-center" },
        {
          data: null,
          className:"text-center",
          render: function (row) {
            return (
              '<button class="btn mb-1 waves-effect waves-light btn-sm btn-secondary modalUserAcccess-btn" data-id="'+row.id+'" data-bs-target="#userAccess_modal">User Access</button>'
            );
          },
        },
      ],
    });

    return pageList_tbl;
  }

  function fetchData(url, data) {
    return $.ajax({
      type  : "post",
      url: url,
      data: data,
      dataType: "json",
      beforeSend: function () {
        $("body").addClass("loading");
      },
      complete: function () {
        $("body").removeClass("loading");
      },
    })
      .done(function (response) {
        return response;
      })
      .fail(function (jqXHR, exception) {
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


});
