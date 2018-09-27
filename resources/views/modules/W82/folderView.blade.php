@extends('modules.W82.bi')
@section("folderView")
    @parent
    <div class="card">
        @section("rightToolbar")
            @include("modules.W82.rightToolbar")
        @show
        <div class="card-body">

            <div id="bootstrap-data-table_wrapper"
                 class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer table-documentary">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="bootstrap-data-table"
                               class="table table-striped table-bordered dataTable no-footer table-hover" role="grid"
                               aria-describedby="bootstrap-data-table_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="bootstrap-data-table"
                                    rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending"
                                    style="width: 5%">
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="bootstrap-data-table"
                                    rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending"
                                    style="width: 20%">Tên
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="bootstrap-data-table"
                                    rowspan="1" colspan="1"
                                    style="width: 10%;">Mô tả
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="bootstrap-data-table"
                                    rowspan="1" colspan="1"
                                    style="width: 10%;">Người tạo
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="bootstrap-data-table"
                                    rowspan="1" colspan="1"
                                    style="width: 10%;">Ngày tạo
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="bootstrap-data-table"
                                    rowspan="1" colspan="1"
                                    style="width: 10%;">Người sửa cuối
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="bootstrap-data-table"
                                    rowspan="1" colspan="1"
                                    style="width: 10%;">Ngày sửa cuối
                                </th>
                            </tr>
                            </thead>
                            <tbody>


                            <?php
                            /** List all folders */
                            if (count($childFolders) > 0) :
                            ?>
                            <?php
                            foreach ($childFolders as $folder) :
                            ?>
                            <?php
                            ?>
                            <tr role="row" class="odd bi-table-item type-folder" folder_id="<?php  echo $folder->ID?>">
                                <td></td>
                                <td><span class="folder-icon"><img src="{{ asset("/media/default_folder_icon.png") }}"
                                                                   alt=""></span><?php echo isset($folder->FolderName) ? $folder->FolderName : ""?>
                                </td>
                                <td><?php echo isset($folder->FolderDescription) ? $folder->FolderDescription : ""?></td>
                                <td><?php echo $folder->CreateUserID ? $folder->CreateUserID : ""?></td>
                                <td><?php echo date("Y-m-d",strtotime($folder->CreateDate))?></td>
                                <td><?php echo isset($folder->LastModifyUserID) ? $folder->LastModifyUserID : ""?></td>
                                <td><?php echo date("Y-m-d",strtotime($folder->LastModifyDate))?></td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                            <?php endif;?>

                            <?php
                            /** List all documents */
                            if (count($childDocuments) > 0) :
                            ?>
                            <?php
                            foreach ($childDocuments as $document) :
                            ?>
                            <?php
                            ?>
                            <tr role="row" class="odd bi-table-item type-document" document_id="<?php  echo $document->ID?>">
                                <td style="text-align: center; vertical-align: middle">
                                    <span class="shareDocument" data-id="{{isset($document->ID) ? $document->ID : ''}}"><i class="far fa-share"></i></span>
                                </td>
                                <td><span class="folder-icon"><img src="{{ asset("/media/default_document_icon.png") }}"
                                                                   alt=""></span><?php echo isset($document->Name) ? $document->Name : ""?>
                                </td>
                                <td><?php ?></td>
                                <td><?php echo $document->CreateUserID ? $document->CreateUserID : ""?></td>
                                <td><?php echo date("Y-m-d",strtotime($document->CreateDate))?></td>
                                <td><?php echo isset($document->LastModifyUserID) ? $document->LastModifyUserID : ""?></td>
                                <td><?php echo date("Y-m-d",strtotime($document->LastModifyDate))?></td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                            <?php endif;?>


                            </tbody>
                        </table>
                        <?php if ((count($childFolders) == 0) && (count($childDocuments) == 0)) :?>
                        <div class="col-sm-12">
                            <div class="alert  alert-warning alert-dismissible fade show" role="alert">
                                <span class="badge badge-pill badge-warning">Lưu ý</span> Thư mục này trống
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            //Bi
            //share document....
            $('.shareDocument').on('click', function () {
                var el = this;
                var item_id = $(el).data('id');

                var data = {documentId: item_id, _token: '{{csrf_token()}}'};
                showFormDialogPost('{{url('/bi/folder/share')}}', 'modalShareDocument', data,  null, null, null);
            });

        });
    </script>
@stop