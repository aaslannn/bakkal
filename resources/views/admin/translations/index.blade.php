@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('translations/title.management')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/select2.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/extensions/bootstrap/dataTables.bootstrap.css') }}">
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<!--end of page level css-->
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>@lang('translations/title.management')</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                {{ trans('panel.home') }}
            </a>
        </li>
        <li>@lang('translations/title.translations')</li>
        <li class="active">@lang('translations/title.management')</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="bank" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('translations/title.translations')
                    </h4>
                    <div class="pull-right">
                        @if (Sentry::getUser()->hasAccess('admin')  || Sentry::getUser()->hasAccess('translations_add'))
                            <a href="{{ route('create/translation') }}" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> @lang('button.create')</a>
                        @endif
                    </div>
                </div>
                <br />
                <div class="panel-body">
                    @if ($translations->count() >= 1)
                        <?php $langs = \App\Language::whereDurum(1)->get(); ?>
                        <div id="sample_editable_1_wrapper" class="">
                            <form name="transForm" id="transForm" class="form-horizontal" role="form" method="post" action="">
                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_editable_1" role="grid">
                                    <thead>
                                        <tr>
                                            <th>@lang('translations/table.slug')</th>
                                            @foreach($langs as $lang)
                                                <th>{{ $lang->dil }}</th>
                                            @endforeach
                                            <th>@lang('button.edit')</th>
                                            <th>@lang('button.delete')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($translations as $trans)
                                            <tr data-id="{{{ $trans->id }}}">
                                                <td>{{{ $trans->slug }}}</td>
                                                @foreach($langs as $lang)
                                                    <td>{{ $trans->{'lang_'.$lang->kisaltma} }}</td>
                                                @endforeach
                                                <td><a class="edit" href="javascript:;">@lang('button.edit')</a></td>
                                                <td><a href="{{ route('confirm-delete/translation', $trans->id) }}" data-toggle="modal" data-target="#delete_confirm">@lang('button.delete')</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    @else
                        @lang('general.noresults')
                    @endif   
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>




@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/select2.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/extensions/bootstrap/3/dataTables.bootstrap.min.js') }}" ></script>
<script>
    jQuery(document).ready(function()
    {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<input type="text" name="slug" class="form-control input-small" value="' + aData[0] + '">';
            <?php
            $i = 1;
            foreach($langs as $lang) {
            ?>
                jqTds[<?php echo $i ?>].innerHTML = '<input type="text" name="lang_<?php echo $lang->kisaltma ?>" class="form-control" value="' + aData[<?php echo $i ?>] + '">';
            <?php
                    $i++;
             } ?>
            jqTds[<?php echo $i ?>].innerHTML = '<a class="edit" href="">@lang('button.save')</a>';
            jqTds[<?php echo $i+1 ?>].innerHTML = '<a class="cancel" href="">@lang('button.cancel')</a>';
        }

        function saveRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            <?php
                    $i = 1;
                    foreach($langs as $lang) {
                    ?>
                    oTable.fnUpdate(jqInputs[<?php echo $i ?>].value, nRow, <?php echo $i ?>, false);
            <?php
                    $i++;
             } ?>
            oTable.fnUpdate('<a class="edit" href="">@lang('button.edit')</a>', nRow, <?php echo $i ?>, false);
            oTable.fnUpdate('<a class="delete" href="">@lang('button.delete')</a>', nRow, <?php echo $i+1 ?>, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            <?php
                    $i = 1;
                    foreach($langs as $lang) {
                    ?>
                    oTable.fnUpdate(jqInputs[<?php echo $i ?>].value, nRow, <?php echo $i ?>, false);
            <?php
                    $i++;
             } ?>
            oTable.fnUpdate('<a class="edit" href="">@lang('button.edit')</a>', nRow, <?php echo $i ?>, false);
            oTable.fnDraw();
        }

        var table = $('#sample_editable_1');

        var oTable = table.dataTable({
            "lengthMenu": [
                [10, 20, 50, -1],
                [10, 20, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 50,
            "language" : {
                "lengthMenu" : "Sayfada  _MENU_  kayıt göster",
                "zeroRecords" : "Kayıt Bulunmamaktadır",
                "info": "_PAGE_ / _PAGES_",
                "infoEmpty": "Gösterilecek kayıt bulunamadı",
                "infoFiltered" : "(Toplam _MAX_ kayıt filtrelendi)",
                "search": "Arama : ",
                "oPaginate": {sFirst: "İlk", sLast: "Son", sNext: "Sonraki", sPrevious: "Önceki"},
            },
            "columnDefs": [{ // set default column settings
                'orderable': true,
                'targets': [0]
            }, {
                "searchable": true,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = $("#sample_editable_1_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: false //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $('#sample_editable_1_new').click(function (e) {
            e.preventDefault();

            if (nNew && nEditing) {
                if (confirm("Previous row not saved. Do you want to save it ?")) {
                    saveRow(oTable, nEditing); // save
                    $(nEditing).find("td:first").html("Untitled");
                    nEditing = null;
                    nNew = false;

                } else {
                    oTable.fnDeleteRow(nEditing); // cancel
                    nEditing = null;
                    nNew = false;

                    return;
                }
            }

            var aiNew = oTable.fnAddData(['', '', '', '', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Are you sure to delete this row ?") == false) {
                return;
            }

            var nRow = $(this).parents('tr')[0];
            oTable.fnDeleteRow(nRow);
            alert("Deleted! Do not forget to do some ajax to sync with backend :)");
        });

        table.on('click', '.cancel', function (e) {
            e.preventDefault();

            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();

            /* Get the row as a parent of the link that was clicked on */
            var self = $(this),
                    nRow = self.parents('tr')[0],
                    dataId = self.parents('tr').attr("data-id");

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "@lang('button.save')") {
                /* Editing this row and want to save it */

                //backendSaveRow(dataId, nEditing); /*ajax php save*/
                saveRow(oTable, nEditing);
                nEditing = null;
                /*alert("Updated! Do not forget to do some ajax to sync with backend :)");*/
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });

        function backendSaveRow(dataId, nRow) {
            var jqInputs = $('input', nRow),
                    o = {},
                    a = jqInputs.serializeArray();

            o['_token'] = $('input[name="_token"]').val();
            o['id'] = dataId;
            $.each(a, function(){
                if(o[this.name] !== undefined){
                    if(!o[this.name].push){
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                }
                else {
                    o[this.name] = this.value || '';
                }
            });

            $.ajax({
                url: '/editTranslation',
                type: 'post',
                data: o,
                dataType: "html",
                beforeSend: function(xhr){
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if(token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                success: function(data){
                    alert(data);
                },
                error: function(){
                    alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
                    location.reload();
                }
            });

        }


    });
</script>
@stop
