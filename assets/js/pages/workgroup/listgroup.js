// JavaScript Document
var i = 0;
var content;
var options;
var editor;
var ck;
var dataJ;
var loop;
var tree;
var warehouse_id ;
var drag_parent = "";
var addNode = false;
$(function() {
  //alert("dfdfd");
  $.ajax({
      type: "POST",
      url: base_url+"pcgadmin/workgroup/getlist_group/",
      dataType: 'json',
      //data: 'mode=warehouse&warehouse_id='+warehouse_id,
      data: 'mode=warehouse',
      success: function(val) {
          console.log(val);
          dataJ = val;
      }
  });
  loop = setInterval('moverItem()', 500);

  if ($('input[name="warehouse_id"]').val().trim() !== "") {
      warehouse_id = $('input[name="warehouse_id"]').val();
      //var actiewarehouse = $('#warehouse'+warehouse_id).find('a i').first();
      //actiewarehouse.removeClass('fa fa-inbox').addClass('fa fa-file-o');
      //console.log(actiewarehouse);
      //getgroup();
  }else {
      //console.log("null");
  }


});
function getgroup() {
  $.ajax({
      type: "POST",
      url: base_url+"pcgadmin/workgroup/getlist_group/",
      dataType: 'json',
      data: 'mode=showgroup',
      success: function(json) {
          createJSTrees(json)
      }
  });
}
function createJSTrees(jsonData) {
  $('#group_all').jstree({
      "core": {
          "animation": 0,
          "check_callback": true,
          "strings": {
              new_node: "New category name",
          },
          'force_text': true,
          'data':jsonData
      },
      "types": {
          "#": {
              "valid_children": ["root"]
          },
          "root": {
              "icon": "fa fa-home",
              "valid_children": ["default"]
          },
          "default": {
              "icon": "glyphicon glyphicon-folder-close",
              "valid_children": ["file"]
          },
          "file": {
              "icon": "fa fa-user-o",
              "valid_children": []
          }
      },
      "dnd": {
          check_while_dragging: true
      },
      "plugins": ["contextmenu", "dnd", "search", "state", "types", "wholerow", "ui"]
          //"plugins": ["contextmenu", "search", "state", "types", "wholerow", "ui"]
  }).bind("move_node.jstree", function(e, data) {
  });
}

function moverItem() {
    if (typeof dataJ !== "undefined") {
        clearInterval(loop);
        $('#evts').jstree({
            "core": {
                "animation": 0,
                "check_callback": true,
                "strings": {
                    new_node: "New category name",
                },
                'force_text': true,
                // "themes": {
                //     'name': 'proton',
                //     'responsive': true
                // },
                'data': dataJ
            },
            "types": {
                "#": {
                    "valid_children": ["root"],
                    "draggable" : false
                },
                "root": {
                    "icon": "fa fa-home fa-2",
                     "draggable" : false,
                    "valid_children": ["default"]
                },
                "default": {
                    "icon": "glyphicon glyphicon-folder-close",
                    "valid_children": ["file"]
                },
                "file": {
                    "icon": "fa fa-user-o",
                    "valid_children": []
                }
            },
            "dnd": {
              check_while_dragging: true,
              "is_draggable" : function(node) {
                if (node[0].type === 'default'||node[0].type ==='root') {
                  //alert('this type is not draggable');
                return false;
                }
                return true;
              }
            },
            "plugins": ["contextmenu", "dnd", "search", "state", "types", "wholerow", "ui"]
                //"plugins": ["contextmenu", "search", "state", "types", "wholerow", "ui"]
        }).bind("move_node.jstree", function(e, data) {
            // console.log(data.node.id);
            // console.log(data.parent);
            // drag_parent = data.parent;
            // node_drag[].parent = data.parent;
            // console.log("id : "+data.node.id+",");
            // console.log("parent : "+data.parent+",");
            // $.ajax({
            //     type: "POST",
            //     url: base_url + 'my_blog/updateCateParent',
            //     data: "id="+data.node.id+"&newparent=" +data.parent,
            //     dataType: 'json',
            //     success: function(val) {
            //         if (val.state === "fail") {
            //             alert("please try again");
            //             $('#evts').jstree(true).refresh();
            //         } else {
            //             console.log(val.state);
            //         }
            //     },
            // });

        });
        return true;
    }

}

$('#evts').on("select_node.jstree", function(node, data) {
  console.log();
    // if (data.node.type == "file") {
    //       console.log();
    // }
    // if (data.node.type == "default") {
    //       console.log("default");
    // }
});

$(document).on('dnd_stop.vakata', function(e, data, helper, event) {
    var tmp_id = data.event.target.attributes[3].value;
    var newParentid = tmp_id.replace("_anchor", "");
    var newParenttype = $('#evts').jstree(true).get_node(newParentid).type;
    if (newParenttype == "file" ) {
      newParent = $('#evts').jstree(true).get_node(newParentid).parent;
    }else{
      newParent = newParentid;
    }
    console.log(oldParent);
    var tmp = [];
    var obj = {};
    $.each($("#evts").jstree("get_selected", true), function() {
        //console.log(this.original);
        oldParent = this.original.real_parent;
        newParent = $('#evts').jstree(true).get_node(newParentid).original.real_parent;
        tmp.push({
            type: this.type,
            name: this.text,
            id: this.id,
            newParent : newParent,
            oldParent :oldParent
        });
    });
    //console.log(tmp[0]);

    if (tmp.length > 0) {

        tmp = JSON.stringify(tmp[0]);
        ////////////////////////////////
        $.ajax({
            type: "POST",
            url: base_url+"pcgadmin/workgroup/getlist_group/",
            data: "mode=upDategroup&data=" +tmp,
            dataType: 'json',
            success: function(val) {
                console.log(val);
                resfreshJSTree();
                // return false;
                if (val.state === "fail") {
                    alert("please try again");
                    $('#evts').jstree(true).refresh();
                } else {
                    console.log(val.state);
                    $('#evts').jstree(true).refresh();
                }
            },
        });
        ////////////////////////////////
    } else {
        return false;
    }
});

$('#evts').on("rename_node.jstree", function(node, data) {
    $.ajax({
        type: "POST",
        url: base_url + 'my_blog/chkCate?id=' + data.node.id,
        dataType: 'json',
        success: function(val) {
            if (val.state === "fail") {
                $.ajax({
                    type: "POST",
                    url: base_url + 'my_blog/updateCate?add=true' + "&name=" + data.text,
                    dataType: 'json',
                    success: function(val) {
                        if (val.state === "fail") {
                            alert("please try again");
                            $('#evts').jstree(true).refresh();
                        } else {
                            console.log(val.state);
                            resfreshJSTree();
                        }
                    },
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: base_url + 'my_blog/updateCate?id=' + data.node.id + "&name=" + data.text,
                    dataType: 'json',
                    success: function(val) {
                        if (val.state === "fail") {
                            alert("please try again");
                            $('#evts').jstree(true).refresh();
                        } else {
                            console.log(val.state);
                            resfreshJSTree();
                        }
                    },
                });
            }
        },
    });
});

$('#evts').on("delete_node.jstree", function(node, parent) {
    alert("ddddd");
    if (parent.node.type == "default") {
        console.log(parent.node.id);
        // $.ajax({
        //     type: "POST",
        //     url: base_url + 'my_blog/deleteCate?id='+parent.node.id,
        //     dataType: 'json',
        //     success: function(val) {
        //         if (val.state === "fail") {
        //             alert("please try again");
        //         } else {
        //             console.log(val.state);
        //             resfreshJSTree();
        //         }
        //         loop = setInterval('moverItem()', 500);
        //     },
        // });
    } else if (parent.node.type == "file") {
        console.log(parent.node.id);
        // $.ajax({
        //     type: "POST",
        //     url: base_url + '/my_blog/delete/',
        //     data: "id=" +parent.node.id,
        //     dataType: 'json',
        //     success: function(val) {
        //         //console.log(val);
        //         location.reload();
        //     },
        // });
    }
    // $.ajax({
    //     type: "POST",
    //     url: base_url + 'my_blog/deleteCate?id='+parent.node.id,
    //     dataType: 'json',
    //     success: function(val) {
    //         if (val.state === "fail") {
    //             alert("please try again");
    //         } else {
    //             console.log(val.state);
    //             resfreshJSTree();
    //         }
    //         loop = setInterval('moverItem()', 500);
    //     },
    // });

});

$('#evts').on("dnd_stop.vakata", function(node, parent) {
    console.log("sds");
});

$('#evts').on("create_node.jstree", function(node, parent, position) {
    $.ajax({
        type: "POST",
        url: base_url + 'my_blog/addCate?name=' + parent.node.text + "&parent=" + parent.node.parent,
        dataType: 'json',
        success: function(val) {
            //console.log(val.parent);
            if (val.state === "fail") {
                alert("please try again");

            } else {
                console.log(val.state);
            }

        },
    });
});

// bind customize icon change function in jsTree open_node event.
$('#evts').on('open_node.jstree', function(e, data){
  var icon = $('#' + data.node.id).find('i.jstree-icon.jstree-themeicon.glyphicon-folder-close').first();
  icon.removeClass('glyphicon-folder-close').addClass('glyphicon-folder-open');
  var hicon = $('#' + data.node.id).find('i.jstree-icon.jstree-themeicon.fa fa-home fa-2').first();
  hicon.removeClass('fa fa-home fa-2').addClass('glyphicon-folder-open');
});

// bind customize icon change function in jsTree close_node event.
$('#evts').on('close_node.jstree', function(e, data){
  var icon = $('#' + data.node.id).find('i.jstree-icon.jstree-themeicon.glyphicon-folder-open').first();
  icon.removeClass('glyphicon-folder-open').addClass('glyphicon-folder-close');
});

function resfreshJSTree() {
    $.ajax({
        type: "POST",
        //url: base_url + '/my_blog/getCateJson/',
        url: base_url+"pcgadmin/workgroup/getlist_group/",
        dataType: 'json',
        success: function(val) {
            $('#evts').jstree(true).settings.core.data = val;
            $('#evts').jstree(true).refresh();
        }
    });
}

function demo_rename() {
    var ref = $('#evts').jstree(true),
        sel = ref.get_selected();
    if (sel == 1) {
        swal("Can't rename Main category!")
        return false;
    }
    if (!sel.length) {
        return false;
    }
    sel = sel[0];
    ref.edit(sel);
};

function demo_delete() {
    var tmp = [];
    var obj = {};
    var i = 0;
    $.each($("#evts").jstree("get_selected", true), function() {
        tmp.push({
            type: this.type,
            id: this.id
        });
    });
    console.log(tmp.length);
    if (tmp.length === 0) {
        swal("please select category");
        return false;
    }
    if (!tmp.length) {
        return false;
        swal("Here's a message!")
    }

    tmp = JSON.stringify(tmp);
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: base_url + '/my_blog/deleteCate/',
                    data: "data=" + tmp,
                    success: function(val) {
                        console.log(val);
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        resfreshJSTree();
                    },
                });
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
};

function demo_delete1() {
    var ref = $('#evts').jstree(true),
        sel = ref.get_selected();
    if (sel == 1) {
        swal("Can't delete Main category!")
        return false;
    }
    // var tmp = [];
    // var obj = {};
    // var i = 0;
    // $.each($("#evts").jstree("get_selected",true),function(){
    //     tmp.push({
    //         type: this.type,
    //         id:  this.id
    //     });
    // });
    // console.log(tmp);

    if (!sel.length) {
        return false;
    }
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                ref.delete_node(sel);
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
};

function demo_create() {
    var ref = $('#evts').jstree(true),
        sel = ref.get_selected();
    if (!sel.length) {
        return false;
    }
    console.log(sel);
    sel = sel[0];
    sel = ref.create_node(sel);

    if (sel) {
        ref.edit(sel);
    }
};
