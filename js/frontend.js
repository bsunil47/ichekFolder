$(document).ready(function () {
    if ($('.datatable-1').length > 0) {
        $('.datatable-1').dataTable();
        $('.dataTables_paginate').addClass('btn-group datatable-pagination');
        $('.dataTables_paginate > a').wrapInner('<span />');
        $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
        $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');


    }
    
     $('.datatable-40').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
                'sAjaxSource': base_url + 'merchants/getfollowers',
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
     $('.datatable-41').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
                'sAjaxSource': base_url + 'merchants/getemaillist',
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
     $('.datatable-42').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
                'sAjaxSource': base_url + 'merchants/getcashout',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "5%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false}
                    ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
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
     $('.datatable-43').dataTable
            ({
                "bAutoWidth": false,
                'bProcessing': true,
                'bServerSide': true,
                'sAjaxSource': base_url + 'merchants/gettopup',
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 50, 100], [10, 20, 50, 100]],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {"sWidth": "5%", "bVisible": true, "bSearchable": false, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false},
                    {"bVisible": true, "bSearchable": true, "bSortable": false}
                     ],
                'fnServerData': function (sSource, aoData, fnCallback)
                {
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
    
    $('.dataTables_paginate').addClass('btn-group datatable-pagination');
    $('.dataTables_paginate > a').wrapInner('<span />');
    $('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
    $('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');

});