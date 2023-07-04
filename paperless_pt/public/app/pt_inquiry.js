$(document).ready(function () {
    fetch_stock_no()
    $("#mo_num").keyup(function () {
        var va = $(this).val();
        qq = va.match(/^[0-9]*$/);
        if (qq != null) {
            $("#mo_num").val("MO" + va);
        }
        var va = $(this).val();
        qq = va.match(/^[a-zA-Z]{2}[0-9]{6}/, va);
        $.trim(qq)
    });
    $("#mo_num").keypress(function (e) {
        var val = $.trim( $(this).val())
        if (e.which == 13) {
            get_details(val)
            fetch_operation(val)

        }
    })

    $('.tray-no').on('keypress', '.input-tray-no', function (e) {
        console.log('dwadawdaw')
        var val = $(this).val()
        var mo = $('#hidden-wip-entity-id').val()
        if (e.which == 13) {
            $('.input-tray-no').val(val)

            insert_tray(mo, val)
        }
    })

    $('#mo_inquiry_tbl').on('keypress', '.operation-condition', function (e) {
        var val = $(this).val()
        var wip_entity_id = $(this).attr('data-wip-entity-id')
        var operation_seq_num = $(this).attr('data-seq-num')

        if (e.which == 13) {
            insert_condition(wip_entity_id, operation_seq_num, val)
            $(this).closest('td').find('textarea').val(operation - condition)
        }
    })

    $('#mo_inquiry_tbl').on('click', '.qa-stamp', function (e) {
        var wip_entity_id = $(this).attr('data-wip-entity-id')
        var operation_seq_num = $(this).attr('data-seq-num')
        var $this = $(this)
        Swal.fire({
            title: 'QA Stamp',
            text: '',
            icon: 'info',
            confirmButtonText: 'Accept',
            showDenyButton: true,
            showCancelButton: true,
            denyButtonText: `Reject`,
            html: '<input type="text" class="form-control text-center" id="qa_stamp_no" placeholder="Enter QA stamp no." />'
        }).then(function (result) {
            var qa_stamp_no = $('#qa_stamp_no').val()

            if (result.isConfirmed) {
                insert_qa_stamp('ACCEPT', wip_entity_id, operation_seq_num, qa_stamp_no)
                $this.closest('td').html('<div class="box text-success">TPC <br> ' + qa_stamp_no + '<br> ACC</div> ')
            } else if (result.isDenied) {
                insert_qa_stamp('REJECT', wip_entity_id, operation_seq_num, qa_stamp_no)
                $this.closest('td').html('<div class="triangle text-danger"><p>TPC <br> ' + qa_stamp_no + '<br> REJ</p></div>')
            }

        })
    })

    // $('#btn-print').on('click', function () {

    //     // $(this).remove()
    //     var tray_val = $('.input-tray-no').val()
    //     $('.tray-no').html(tray_val)

    //     var mo_print = $('.mo_print').html();
    //     printKit(mo_print,tray_val)

    // })

    $('#material_tb').on('click', '.add-materials', function () {
        var stock_no = $('#slct_stock_no').val()
        var desc = $('.stock-description').val()
        var lot_no = $('.lot-number').val()
        var qty = $('.quantity').val()

        var wip_name = $('#hidden-wip-entity-name').val()

        if (wip_name != '') {
            insert_material(wip_name, stock_no, desc, lot_no, qty)
        } else {
            Swal.fire('No Mo #!', '', 'error')
        }

        // 

    })

    $('#slct_stock_no').on('change', function () {
        var val = $(this).find(':selected').data('desc')
        $('.stock-description').val(val)
    })

    $('.show-defect').on('click', function () {
        var wip_entity_id = $('#hidden-wip-entity-id').val()
        if (wip_entity_id != '') {
            // fetch_defect(wip_entity_id)
        }
        else {
            Swal.fire('No Mo #!', '', 'error')
        }

    })

    // $('.add-defect').on('click', function () {
    //     $('#modal_create_defect').modal('toggle')
    // })

    // $('.btn-create-defect').on('click', function () {
    //     var wip_name = $('#hidden-wip-entity-name').val()
    //     var defect = $('#slct-defect').val()
    //     var qty = $('#defect_quantity').val()

    //     insert_defect(wip_name, defect, qty)

    // })

    function fetch_operation(mo) {
        $("#mo_inquiry_tbl").DataTable().destroy();
        mo_inquiry_tbl = $("#mo_inquiry_tbl").DataTable({
            ajax: {
                url: 'ajax/mo_inquiry/fetch_operation.php',
                data: {
                    mo: mo,
                },
                type: 'post',
                beforeSend: function () {
                    Swal.fire({
                        title: 'Fetching data of ' + mo,
                        text: 'Please wait...',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    })
                },
                dataSrc: function (json) {

                    if (json.data == null) {
                        // alert("No Data");
                    }
                    swal.close()
                    return json.data;
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
                    alert(msg);
                },
            },
            order: false,
            columns: [
                { data: 'DESCRIPTION', className: "text-center" },
                { data: 'ATTRIBUTE2', className: "text-center" },
                {
                    data: null,
                    className: "text-center",
                    render: function (row) {
                        // var condition = ''
                        // if (row.CONDITION != null) {

                        // } else {
                        condition = '<textarea class="form-control operation-condition" placeholder="Enter condition..." data-wip-entity-id="' + row.WIP_ENTITY_ID + '" data-seq-num="' + row.OPERATION_SEQ_NUM + '" >' + (row.CONDITION != null ? row.CONDITION : '') + '</textarea>'
                        // }
                        return (condition);
                    },
                },
                { data: 'MACHINE[, ]', className: "text-center" },
                { data: 'OPERATOR[, ]', className: "text-center" },
                { data: 'MIN_START', className: "text-center" },
                { data: 'MAX_END', className: "text-center" },
                { data: 'IN', className: 'text-center' },
                { data: 'OUT', className: 'text-center' },
                { data: 'YIELD', className: 'text-center' },
                {
                    data: null,
                    className: "text-center",
                    render: function (row) {
                        var qa_stamp = '<button class="btn btn-success qa-stamp" data-bs-toggle="tooltip" title="Stamp" data-wip-entity-id="' + row.WIP_ENTITY_ID + '" data-seq-num="' + row.OPERATION_SEQ_NUM + '"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rubber-stamp" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">' +
                            '<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>' +
                            '<path d="M21 17.85h-18c0 -4.05 1.421 -4.05 3.79 -4.05c5.21 0 1.21 -4.59 1.21 -6.8a4 4 0 1 1 8 0c0 2.21 -4 6.8 1.21 6.8c2.369 0 3.79 0 3.79 4.05z"></path>' +
                            '<path d="M5 21h14"></path>' +
                            '</svg></button>'

                        if (row.QA == 'accept') {
                            qa_stamp = '<div class="box text-success">TPC <br> ' + row.QA_STAMP + '<br> ACC</div>'
                        } else if (row.QA == 'reject') {
                            qa_stamp = '<div class="triangle text-danger"><p>TPC <br> ' + ow.QA_STAMP + '<br> REJ</p></div>'
                        }
                        return (
                            qa_stamp
                        );
                    },
                },

            ],
            processing: true,
            pageLength: 20,
            columnDefs: [
                {
                    targets: 2,
                    createdCell: function (td, cellData, rowData, row, col) {
                        $(td).addClass("condition");
                    },
                },
                {
                    targets: 10,
                    createdCell: function (td, cellData, rowData, row, col) {
                        // $(td).addClass("d-flex align-items-center justify-content-center");
                    },
                },
            ],
        });

        return mo_inquiry_tbl;
    }

    function get_details(mo) {
        $.ajax({
            url: 'ajax/mo_inquiry/fetch_details.php',
            data: { mo: mo },
            dataType: 'json',
            type: 'post',
            beforeSend: function () {
                $('.input').text(' ')
                $('.mo-details').waitMe()
                // $('#material_tb').html()
                $("#material_tb").find("tr:not(:first)").remove();
            },
            success: function (data) {
                var result = data['result']
                var barcode = data['barcode'];
                var materials = data['materials'];

                $('#btn-print').attr('href', 'print_pt.php?min='+result.MO_RANGE_MIN+'&max='+result.MO_RANGE_MAX)
                $('.barcode').attr('src', barcode)
                $('.mo-details').waitMe('hide')
                $('.customer').text(result.CUSTOMER)
                $('.pt').text(result.WIP_ENTITY_NAME + ' ' + result.RANGE )
                $('.pkg-type').text(result.PKG_TYPE)
                $('.device').text(result.DEVICE)
                $('.lot-no').text(result.LOT_NUMBER)
                $('.ro-jo').text(result.ATTRIBUTE11)
                $('.start-qty').text(result.START_QUANTITY)

                $('.attribute2').text(result.ATTRIBUTE2)
                $('.attribute3').text(result.ATTRIBUTE3)
                $('.bd-no').text(result.BD)

                $('.so-no').text(result.SO_NUM)
                $('.po-no').text(result.PO)
                $('.address').html(result.CUSTOMER+'<br>'+result.ADDRESS1+'<br>'+result.ADDRESS2+'<br>'+result.CITY+', '+result.STATE+', ' +result.PROVINCE+ ' '+ result.CTRY_CODE)

                $('#hidden-wip-entity-name').val(result.WIP_ENTITY_NAME)
                $('#hidden-wip-entity-id').val(result.WIP_ENTITY_ID)
                

                if (result.TRAY != null) {
                    $('.input-tray-no').val(result.TRAY)
                } else {
                    $('.input-tray-no').val('')
                }

                if (materials) {

                    for (var i = 0; i < materials.length; i++) {
                        var body_mat = ''
                        body_mat += '<tr>'
                            + '<td>' + materials[i].stock_no + '</td>'
                            + '<td>' + materials[i].description + '</td>'
                            + '<td>' + materials[i].lot_no + '</td>'
                            + '<td align="right">' + materials[i].quantity + '</td>'
                            + '<td>'
                            + '<button class="btn btn-danger btn-sm remove-materials"><span class="ti ti-minus"></span></button>'
                            + '</td>'
                            + '</tr>';
                        $('#material_tb tr:first').after(body_mat)
                    }
                }
                fetch_defect(result.WIP_ENTITY_ID)
            }
        })
    }

    function insert_condition(wip_entity_id, operation_seq_num, condition) {
        $.ajax({
            url: 'ajax/mo_inquiry/insert_condition.php',
            data: {
                wip_entity_id: wip_entity_id,
                operation_seq_num: operation_seq_num,
                condition: condition
            },
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data == 1) {
                    Swal.fire({
                        title: 'Condition inserted',
                        icon: 'success',
                        text: '',
                        showConfirmButton: false,
                        timer: 1000
                    })
                } else {
                    Swal.fire({
                        title: 'Condition updated',
                        icon: 'success',
                        text: '',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
            }
        })
    }

    function insert_qa_stamp(status, wip_entity_id, operation_seq_num, qa_stamp) {
        $.ajax({
            url: 'ajax/mo_inquiry/insert_qa_stamp.php',
            data: {
                wip_entity_id: wip_entity_id,
                operation_seq_num: operation_seq_num,
                qa_stamp: qa_stamp,
                status: status
            },
            type: 'post',
            dataType: 'json',
            success: function () {

            }
        })
    }

    function insert_tray(mo, tray) {
        $.ajax({
            url: 'ajax/mo_inquiry/insert_tray.php',
            data: { mo: mo, tray: tray },
            dataType: 'json',
            type: 'post',
            success: function (data) {
                if (data == 1) {
                    Swal.fire({
                        title: 'Tray inserted',
                        icon: 'success',
                        text: '',
                        showConfirmButton: false,
                        timer: 1000
                    })
                } else {
                    Swal.fire({
                        title: 'Tray updated',
                        icon: 'success',
                        text: '',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }

            }
        })
    }

    function printKit(divPrint,tray) {
        styles = '<link rel="stylesheet" href="public/theme/css/styles.min.css" />';

        divPrint = divPrint;
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><body onload="window.print()">' + styles + divPrint + '</body></html>');

        newWin.document.close();
        setTimeout(function () {
            newWin.close();
            $('.tray-no').html('<input type="text" class="form-control input-tray-no" placeholder="Enter tray no." style="width: 150px" value="'+(tray != ''? tray : '')+'">')
        }, 10);
    }

    function fetch_stock_no() {
        $('#slct_stock_no').select2({
            ajax: {
                url: 'ajax/mo_inquiry/fetch_stock_no.php',
                dataType: 'json',
                data: function (params) {
                    console.log(params.term)
                    var query = {
                        search: params.term,
                        // type: 'get'
                    }
                    return query;


                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },

            },
            width: '100%',
            placeholder: 'Select option...',
            templateSelection: function (data, container) {
                // Add custom attributes to the <option> tag for the selected option
                $(data.element).attr('data-desc', data.desc);
                return data.text;
            }

        });
    }

    function insert_material(wip_entity_name, stock_no, desc, lot_no, qty) {
        $.ajax({
            url: 'ajax/mo_inquiry/insert_material.php',
            type: 'post',
            dataType: 'json',
            data: {
                wip_entity_name: wip_entity_name,
                stock_no: stock_no,
                desc: desc,
                lot_no: lot_no,
                qty: qty
            },
            success: function (data) {
                var max_id = data
                $('#material_tb').append('<tr><td>' + stock_no + '</td><td>' + desc + '</td><td>' + lot_no + '</td><td align="right">' + qty + '</td><td>' +
                    '<button class="btn btn-danger btn-sm remove-materials" data-id="' + max_id + '"><span class="ti ti-minus"></span></button></td></tr>')
                $('#slct_stock_no').val(null).change()
                $('.lot-number').val(null)
                $('.quantity').val(null)
            }
        })
    }

    function insert_defect(wip_entity_name, defect, qty) {
        $.ajax({
            url: 'ajax/mo_inquiry/insert_defect.php',
            data: {
                wip_entity_name: wip_entity_name,
                defect: defect,
                qty: qty
            },
            dataType: 'json',
            type: 'post',
            success: function (data) {
                data
            }
        })
    }

    // function fetch_defect(wip_entity_id) {
    //     $.ajax({
    //         url: 'ajax/mo_inquiry/fetch_defects.php',
    //         data: { wip_entity_id: wip_entity_id },
    //         type: 'post',
    //         dataType: 'json',
    //         success: function (data) {

    //             var second = data['second']
    //             var third = data['third']
    //             var fourth = data['fourth']
    //             var final_test = data['final_test']

    //             if (second != null) {
    //                 var body_second = ''
    //                 for (var i = 0; i < second.length; i++) {
    //                     body_second += '<tr>'
    //                         + '<td>' + second[i].FLEX_VALUE + '</td>'
    //                         + '<td>' + second[i].TRANSACTION_QUANTITY + '</td>'
    //                         + '</tr>'

    //                 }
    //                 $('#defect2').html(body_second)
    //             }

    //             if (third != null) {
    //                 var body_third = ''
    //                 for (var i = 0; i < third.length; i++) {
    //                     body_third += '<tr>'
    //                         + '<td>' + third[i].FLEX_VALUE + '</td>'
    //                         + '<td>' + third[i].TRANSACTION_QUANTITY + '</td>'
    //                         + '</tr>'

    //                 }
    //                 $('#defect3').html(body_third)
    //             }
    //         }
    //     })
    // }

    function fetch_defect(wip_entity_id) {
        $.ajax({
            url: 'ajax/mo_inquiry/fetch_defects_new.php',
            data: { wip_entity_id: wip_entity_id },
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                $('#defetc2_tb').html('')
                $('#defect3_tb').html('')
                $('#defect4_tb').html('')
                $('#pre_seal_tb').html('')
                $('#isolation_tb').html('')
                $('#os_tb').html('')
                $('#final_tb').html('')
                // $('#defetc2_tb').html('')
            },
            success: function (data) {
                var result = data['result']
                var operation = data['operation']

                if (operation != null) {
                    operation.forEach(element => {
                        if (element.indexOf('2ND') != -1) {
                            fetch_tbody(element, result, 'defetc2_tb')
                        } else if (element.indexOf('3RD') != -1) {
                            fetch_tbody(element, result, 'defect3_tb')
                        } else if (element.indexOf('4TH') != -1) {
                            fetch_tbody(element, result, 'defect4_tb')
                        } else if (element.indexOf('PRE-SEAL') != -1) {
                            fetch_tbody(element, result, 'pre_seal_tb')
                        } else if (element.indexOf('ISOLATION') != -1) {
                            fetch_tbody(element, result, 'isolation_tb')
                        } else if (element.indexOf('OS') != -1) {
                            fetch_tbody(element, result, 'os_tb')
                        } else if (element.indexOf('FINAL TEST') != -1) {
                            fetch_tbody(element, result, 'final_tb')
                        }
                    });
                }

                // if(result != null){

                //     if(result['Wirebond/3RD Opt.Insp.'] !== undefined){
                //         var tbody = ''

                //         for(var i = 0 ; i < result['Wirebond/3RD Opt.Insp.']['FLEX'].length; i++ ){
                //             tbody   += '<tr>'
                //                     +   '<td align="center">'+result['Wirebond/3RD Opt.Insp.']['FLEX'][i]+'</td>'
                //                     +   '<td align="center">'+result['Wirebond/3RD Opt.Insp.']['QTY'][i]+'</td>'
                //                     + '</tr>';
                //         }
                //         fetch_tbody('defect3_tb',tbody)

                //     }

                //     if(result['4th Optical Inspection-Power'] !== undefined){
                //         var tbody = ''
                //         for(var i = 0 ; i < result['4th Optical Inspection-Power']['FLEX'].length; i++ ){
                //             tbody   += '<tr>'
                //                     +   '<td align="center">'+result['4th Optical Inspection-Power']['FLEX'][i]+'</td>'
                //                     +   '<td align="center">'+result['4th Optical Inspection-Power']['QTY'][i]+'</td>'
                //                     + '</tr>';
                //         }
                //         fetch_tbody('defect4_tb',tbody)
                //     }

                //     if(result['Final Test - Power'] !== undefined){
                //         var tbody = ''
                //         for(var i = 0 ; i < result['Final Test - Power']['FLEX'].length; i++ ){
                //             tbody   += '<tr>'
                //                     +   '<td align="center">'+result['Final Test - Power']['FLEX'][i]+'</td>'
                //                     +   '<td align="center">'+result['Final Test - Power']['QTY'][i]+'</td>'
                //                     + '</tr>';
                //         }
                //         fetch_tbody('final_tb',tbody)
                //     }

                //     if(result['4th Optical Inspection-Power'] !== undefined){
                //         var tbody = ''
                //         console.log(result['4th Optical Inspection-Power']['FLEX'].length)
                //     }

                //     if(result['4th Optical Inspection-Power'] !== undefined){
                //         var tbody = ''
                //         console.log(result['4th Optical Inspection-Power']['FLEX'].length)
                //     }

                // }


            }
        })
    }

    function fetch_tbody(operation, result, tbody_id) {
        var tbody = ''
        if (result != null) {
            if (result[operation] !== undefined) {
                for (var i = 0; i < result[operation]['FLEX'].length; i++) {
                    tbody += '<tr>'
                        + '<td align="center">' + result[operation]['FLEX'][i] + '</td>'
                        + '<td align="center">' + result[operation]['QTY'][i] + '</td>'
                        + '</tr>';
                }
                $('#' + tbody_id).html(tbody)
            }
        }
    }


});


