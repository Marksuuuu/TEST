$(document).ready(function () {
    setup_tbl = $('#setup_tbl').DataTable({
        columnDefs : [
            {
                "target": 2,
                "className": "text-center",
            }
        ],
        order: false
    })

    $('.btn-show-tagging').on('click', function(){
        $('#modal_create_tagging').modal('toggle')
        fetch_setup()
    })


    $('.btn-create-tagging').on('click', function(){
        var select_sub_section = $('#select_sub_section').val()
        var select_area = $('#select_area').val()

        var select_sub_section_text = $('#select_sub_section option:selected').text()
        var select_area_text = $('#select_area option:selected').text()

        insert_tagging(select_sub_section,select_area,select_sub_section_text,select_area_text)
        
    })







    // functions

    function fetch_setup(){
        $.ajax({
            url: 'ajax/setup/fetch_tagging.php',
            dataType: 'json',
            beforeSend: function(){
                $('.waitme-tagging').waitMe()
            },
            success: function(data){
                $('.waitme-tagging').waitMe('hide')
                console.log(data)
                var sub_section = data['sub_section'];
                var area = data['area']

                if(sub_section){
                    var opt_sub = ''
                    for(var i = 0 ; i < sub_section.length; i++){
                        opt_sub += '<option value="'+sub_section[i].id+'">'+sub_section[i].name+'</option>'
                    }
                    $('#select_sub_section').html(opt_sub)
                }

                if(area){
                    var opt = ''
                    for(var i = 0 ; i < area.length; i++){
                        opt += '<option value="'+area[i].id+'">'+area[i].area_name+'</option>'
                    }
                    $('#select_area').html(opt)
                }
            }
        })
    }

    function insert_tagging(select_sub_section,select_area,select_sub_section_text,select_area_text){
        $.ajax({
            url: 'ajax/setup/insert_tagging.php',
            data: {
                select_sub_section: select_sub_section,
                select_area: select_area,
                select_sub_section_text: select_sub_section_text,
                select_area_text: select_area_text
            },
            type: 'post',
            dataType: 'json',
            beforeSend: function(){
                $('.waitme-tagging').waitMe()
            },
            success: function(data){
                $('.waitme-tagging').waitMe('hide')
                console.log(data)
                setup_tbl.row .add(
                    [
                        select_sub_section_text,
                        select_area_text,
                        '<button type="button" class="d-inline-flex align-items-center justify-content-center btn btn-danger btn-circle btn-lg" data-id="'+data+'" data-bs-toggle="tooltip" title="Remove">'+
                        '<i class="fs-5 ti ti-trash"></i>'+
                        '</button>'
                    ]) .draw(false);
            },
            complete: function(){
                $('#modal_create_tagging').modal('toggle')
            },
            error: function (jqXHR, exception) {
                $('.waitme-tagging').waitMe('hide')
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
				alert(msg);
			},
        })
    }
});
