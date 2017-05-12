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

    //Display invited merchants

    $('.datatable-12').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/merchants/getInvited',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "1%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false}
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

    //End of display invited merchants

    //Display cash out points
    $('.datatable-13').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/finance/getData',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
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

    //End of display cash out points

    //Display Top Up List
    $('.datatable-14').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/finance/getTopup',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
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

    //End of display Top Up List

    //Display Categories

    $('.datatable-15').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/settings/getcatData',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
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

    //End of display Categories

    //Display Followers Management
    $('.datatable-16').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/merchants/getfollowers',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "5%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "15%", "bVisible": true, "bSearchable": false, "bSortable": false},
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

    //Display Redeemed Offer
    $('.datatable-27').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/statistics/getData',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "5%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
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

    //Display Active Users
    $('.datatable-28').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/statistics/getDataactive',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "5%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
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

    //Display Active Merchants
    $('.datatable-29').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/statistics/getDataactivemerchants',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "5%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
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

    $('.datatable-30').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/statistics/getsortingdata',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "5%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false}
                ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
                    aoData.push({
                        name: 'from_date',
                        value: $("#fromdate").val()
                    });
                    aoData.push({
                        name: 'to_date',
                        value: $("#todate").val()
                    });
                    aoData.push({
                        name: 'sort_type',
                        value: $("#sorttype").val()
                    });
                    aoData.push({
                        name: 'user_id',
                        value: $("#user_id").val()
                    });
                    console.log(aoData);
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

//Display Email Blast
    $('.datatable-35').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/merchants/getemail',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "5%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "20%", "bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"sWidth": "3%", "bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": false, "bSortable": false},
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

    $('.datatable-31    ').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
//                'sPaginationType': 'full_numbers',
                'sAjaxSource': base_url + 'Admin/merchants_1/getData',
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

    //Display login List
    if(userid_log != null){
        $('.datatable-32').dataTable
        ({
            "bAutoWidth": false,
            'bProcessing': true,
            'bServerSide': true,
//                'sPaginationType': 'full_numbers',
            'sAjaxSource': base_url + 'Admin/users/getdatalogintimes/'+userid_log,
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
            "aaSorting": [[1, 'asc']],
            "aoColumns": [
                {"sWidth": "12%", "bVisible": true, "bSearchable": true, "bSortable": true},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false},
                {"bVisible": true, "bSearchable": true, "bSortable": false}
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
    }


    //End of display Customers List
    $('.dataTables_paginate').addClass('btn-group datatable-pagination');
    $('.dataTables_paginate > a').wrapInner('<span />');
    $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
    $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');

});