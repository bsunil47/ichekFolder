$(document).ready(function () {
    if ($('.datatable-1').length > 0) {
        $('.datatable-1').dataTable();
        $('.dataTables_paginate').addClass('btn-group datatable-pagination');
        $('.dataTables_paginate > a').wrapInner('<span />');
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');


    }
    $('.datatable-2').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/merchants/getData',
                "iDisplayLength": 20,
                "aLengthMenu": [[5, 20, 50, 100], [5, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "18%", "bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}
                ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback
                            });

                }
            });

    //Display Admin userslist

    $('.datatable-3').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/users/getData',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "18%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}

                ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback,
                            });

                }
            });

    //End of display Admin userslist

    //Display Merchants List

    $('.datatable-4').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/users/getdataMerchants',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "18%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}

                ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback,
                            });

                }
            });

    //End of display Merchants List

    //Display Customers List

    $('.datatable-5').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/users/getdataCustomers',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "18%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}

                ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback,
                            });

                }
            });

    //End of display Customers List

    //Display icheksettings

    $('.datatable-6').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/settings/getData',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "18%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}

                ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback,
                            });

                }
            });

    //End of display icheksettings

    //Display ichekpoints

    $('.datatable-7').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/points/getData',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "18%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}

                ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback,
                            });

                }
            });

    //End of display ichekpoints

    //Display ichekreviews

    $('.datatable-9').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/review/getData',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "18%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}

                ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback,
                            });

                }
            });

    //End of display ichekreviews

    //Display ichek reported reviews

    $('.datatable-10').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/review/getDataReports',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "18%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}

                ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    $.ajax
                            ({
                                'dataType': 'json',
                                'type': 'POST',
                                'url': sSource,
                                'data': aoData,
                                'success': fnCallback,
                            });

                }
            });

    //End of display ichek reported reviews

    $('.dataTables_paginate').addClass('btn-group datatable-pagination');
    $('.dataTables_paginate > a').wrapInner('<span />');
    $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
    $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');

});
