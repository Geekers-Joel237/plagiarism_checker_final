window.onload = function exampleFunction() {
    var url = "{{ route('admin.get_type_entity_api') }}";
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function(response) {
            // console.log(response);
            var zNodes1 = response;
            var setting = {
                view: {
                    selectedMulti: false
                },
                data: {
                    key: {
                        title: "t"
                    },
                    simpleData: {
                        enable: true
                    }
                },
                callback: {
                    onClick: function myOnClick(event, treeId, treeNode) {
                        // console.log(treeNode.description);
                        event.preventDefault();
                        $("#code").append('');
                        $("#descript").append('');
                        var url = "";
                        var name = treeNode.name;
                        var description = treeNode.description;
                        var type = treeNode.type;

                        var infos = "";
                        infos += "<p><b>Code:</b> " + treeNode.code + "</p>";
                        infos += "<p><b>Description:</b> " + treeNode.description + "</p>";
                        var pare = "";
                        pare += "<input type='hidden' name='parent_id' value='" + treeNode.id + "'/>";

                        var btnn = "";
                        btnn += "<a id='add_element-" + treeNode.id + "' onclick='event.preventDefault();show_add_sub(" + treeNode.id + ")' data-toggle='modal' data-target='#add_childModal-" + treeNode.id + "' class='btn btn-icon btn-success'><i class='fas fa-plus'></i></a>&nbsp;&nbsp;";
                        btnn += "<a id='view_element-" + treeNode.id + "' onclick='event.preventDefault();show_view_sub(" + treeNode.id + ")' data-toggle='modal' data-target='#view_childModal-" + treeNode.id + "' class='btn btn-icon btn-primary'><i class='far fa-eye'></i></a>&nbsp;&nbsp;";
                        btnn += "<a id='edit_element-" + treeNode.id + "' onclick='event.preventDefault();show_edit_sub(" + treeNode.id + ")' data-toggle='modal' data-target='#edit_childModal-" + treeNode.id + "' class='btn btn-icon btn-warning'><i class='far fa-edit'></i></a>&nbsp;&nbsp;";
                        btnn += "<a id='del_element-" + treeNode.id + "' onclick='event.preventDefault();show_delete_sub(" + treeNode.id + ")' data-toggle='modal' data-target='#del_childModal-" + treeNode.id + "' class='btn btn-icon btn-danger'><i class='fas fa-trash'></i></a>";

                        $("#mybody_card").html(infos);
                        $("#footery").html(btnn);
                        //console.log()
                        $("#add_parent_subentity").html(pare);

                        $("#mycard").css("display", "block");
                    },
                }
            };

            $.fn.zTree.init($("#fileplanTree"), setting, zNodes1);
        },
        error: function(response) {
            console.log(response);
        },
    });
}


function show_add_sub(id) {
    console.log(id);
    var url = "{{ route('admin.entite.index') }}" + "/" + id + "/edit";

    $.ajax({
        url: url,
        type: 'GET',
        success: function(data) {
            console.log(data);
            if (data == 'off') {
                iziToast.error({
                    title: 'error',
                    message: 'error',
                    position: 'topRight'
                });

            } else {
                console.log(data);
                // $("#id_entity").val(data.id);
                $("#parent").val(data.libele);


                $('#add_my_child').modal('show');
            }
        }
    })

}
//edit entity
function show_edit_sub(id) {
    // console.log(id);
    var url = "{{ route('admin.entite.index') }}" + "/" + id + "/edit";

    $.ajax({
        url: url,
        type: 'GET',
        success: function(data) {
            console.log(data);
            if (data == 'off') {
                iziToast.error({
                    title: 'error',
                    message: 'error',
                    position: 'topRight'
                });
            } else {
                // $("#id_entity").val(data.id);
                $("#update_parent_id_a").val(data.id);
                $("#update_code").val(data.code);
                $("#update_libele").val(data.libele);
                $("#update_description").val(data.description);
                $('#edit_my_child').modal('show');
            }
        }
    })

}

function show_view_sub(id) {
    var url = "{{ route('admin.entite.index') }}" + "/" + id + "/edit";
    $.ajax({
        url: url,
        type: 'GET',
        success: function(data) {
            console.log(data);
            if (data == 'off') {
                iziToast.error({
                    title: 'error',
                    message: 'error',
                    position: 'topRight'
                });
            } else {
                var w = "";
                w += "<p><b>Code:</b> " + data.code + "</p>";
                w += "<p><b>Libele:</b> " + data.libele + "</p>";
                w += "<p><b>Description:</b> " + data.description + "</p>";
                $("#viewer").html(w);
                $('#show_my_child').modal('show');
            }
        }
    })

}

//delete
function show_delete_sub(id) {
    // var url = "{{ route('admin.entite.index') }}"+"/"+id+"/destroy";
    swal({
            title: 'Are you sure?',
            text: 'Once deleted, you will not be able to recover this information!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var url = "{{ route('admin.entite.destroy', ':id') }}";
                url = url.replace(':id', id);

                var xhr = new XMLHttpRequest();
                xhr.open('DELETE', url);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.onload = function() {
                    if (xhr.status === 200) {

                        var response = JSON.parse(xhr.responseText);
                        console.log(response);
                        if (response == 'ok') {
                            iziToast.success({
                                title: 'success !',
                                message: 'Success in deletion',
                                position: 'topRight'
                            });
                            location.reload();
                        } else {
                            iziToast.error({
                                title: 'error !',
                                message: 'Error in deletion',
                                position: 'topRight'
                            });
                            location.reload();
                        }
                    }
                };
                xhr.send();
                // document.location.href = url;
            } else {
                iziToast.error({
                    title: 'error !',
                    message: 'Canceled',
                    position: 'topRight'
                });
            }
        });
}

function delete_entity(id) {
    swal({
            title: 'Are you sure?',
            text: 'Once deleted, you will not be able to recover this information!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                document.getElementById('delete-form' + id).submit();

            } else {
                swal('Canceled!');
            }
        });
}


function edit_entity(id) {
    var url = "{{route('admin.get_type_entity', [": b_id "])}}";
    url = url.replace(':b_id', id);
    $.ajax({
        url: url,
        type: 'GET',
        success: function(data) {
            if (data == 'off') {
                iziToast.error({
                    title: 'error',
                    message: 'error',
                    position: 'topRight'
                });

            } else {
                console.log(data);
                $("#id_entity").val(data.id);
                $("#privilege_name_1").val(data.libele);
                $("#designation").val(data.description);


                $("#editorganisationModal").modal('show');
            }

        }
    })
}