/***********
 ***********
 ***********
 Permission
 ***********
 ***********
 ***********/
$("#checkPermissionAll").click(function(){
    if($(this).is(':checked')){
        // check all the checkbox
        $('input[type=checkbox]').prop('checked', true);
    }else{
        // un check all the checkbox
        $('input[type=checkbox]').prop('checked', false);
    }
});

function checkPermissionByGroup(className, checkThis){
    const groupIdName = $("#"+checkThis.id);
    const classCheckBox = $('.'+className+' input');

    if(groupIdName.is(':checked')){
        classCheckBox.prop('checked', true);
    }else{
        classCheckBox.prop('checked', false);
    }
    implementAllChecked();
}

function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
    const classCheckbox = $('.'+groupClassName+ ' input');
    const groupIDCheckBox = $("#"+groupID);

    // if there is any occurance where something is not selected then make selected = false
    if($('.'+groupClassName+ ' input:checked').length == countTotalPermission){
        groupIDCheckBox.prop('checked', true);
    }else{
        groupIDCheckBox.prop('checked', false);
    }
    implementAllChecked();
}

function implementAllChecked() {

    //  console.log((countPermissions + countPermissionGroups));
    //  console.log($('input[type="checkbox"]:checked').length);

    if($('input[type="checkbox"]:checked').length >= ($all_permissions + $permission_groups)){
        $("#checkPermissionAll").prop('checked', true);
    }else{
        $("#checkPermissionAll").prop('checked', false);
    }
}

/***********
 ***********
 ***********
 DataTable
 ***********
 ***********
 ***********/
$('.datatable').DataTable( {
    order: [],
    "columnDefs": [ {
        "targets"  : 'no-sort',
        "orderable": false,
    }],
    language: {
        processing:     "Traitement en cours...",
        search:         "<i class=\"fa-solid fa-magnifying-glass\"></i>",
        lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
        info:           "_TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable:     "Aucune donnée disponible dans le tableau",
        paginate: {
            first:      "<i class=\"fa-solid fa-backward-fast\"></i>",
            previous:   "<i class=\"fa-solid fa-backward-step\"></i>",
            next:       "<i class=\"fa-solid fa-forward-step\"></i>",
            last:       "<i class=\"fa-solid fa-forward-fast\"></i>"
        },
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    }
} );

$('#datatableproduit').DataTable( {
    order: [],
    "columnDefs": [ {
        "targets"  : 'no-sort',
        "orderable": false,
    }],
    language: {
        processing:     "Traitement en cours...",
        search:         "<i class=\"fa-solid fa-magnifying-glass\"></i>",
        lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
        info:           "_TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable:     "Aucune donnée disponible dans le tableau",
        paginate: {
            first:      "<i class=\"fa-solid fa-backward-fast\"></i>",
            previous:   "<i class=\"fa-solid fa-backward-step\"></i>",
            next:       "<i class=\"fa-solid fa-forward-step\"></i>",
            last:       "<i class=\"fa-solid fa-forward-fast\"></i>"
        },
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    }
} );

/***********
 ***********
 ***********
 Autohide Alert
 ***********
 ***********
 ***********/
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);

/***********
 ***********
 ***********
 TomSelect
 ***********
 ***********
 ***********/
const tomselect = document.querySelector(".tomselect");
if (tomselect) {
    new TomSelect(tomselect, {
        persist: false,
        createOnBlur: true,
        create: false,
        render: {
            no_results: function (data, escape) {
                return '<div class="no-results">Aucun résultat trouvé</div>';
            },
        },
    });
}

const tomselectmultiple = document.querySelector(".tomselectmultiple");
if (tomselectmultiple) {
    new TomSelect(tomselectmultiple,{
        plugins:['remove_button'],
        persist: false,
        create: true,
        maxOptions: 100,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
}

/***********
 ***********
 ***********
 SummerNote
 ***********
 ***********
 ***********/
$(document).ready(function () {
    $('.summernote').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['forecolor', 'backcolor']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview']],
        ],
        popover: {
            image: [
                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
            link: [
                ['link', ['linkDialogShow', 'unlink']]
            ],
            table: [
                ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
            ],
            air: [
                ['color', ['color']],
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']]
            ]
        },
        lang: 'fr-FR',
        height: 600,
        callbacks:{
            onImageUpload:function(file){
                $('.summernote').summernote('disable')
                const frmData = new FormData();
                frmData.append('image',file[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url:'/',
                    method:'POST',
                    contentType:false,
                    processData:false,
                    data:frmData,
                    success:function(data){
                        $('.summernote').summernote('insertImage',data)
                        $('.summernote').summernote('enable')
                    }
                })
            },
        }
    });
});

/***********
 ***********
 ***********
 Sortable category
 ***********
 ***********
 ***********/
$(function() {
    function makeSortable() {
        $("#sortable-categories, .sortable-subcategories").sortable({
            connectWith: "#sortable-categories, .sortable-subcategories",
            update: function(event, ui) {
                if (this === ui.item.parent()[0]) {
                    updateOrder();
                }
            }
        }).disableSelection();
    }
    makeSortable();

    function updateOrder() {
        var order = [];
        $("#sortable-categories > li").each(function() {
            var categoryId = $(this).data('id');
            var subCategoryOrder = getSubCategoriesOrder($(this));
            order.push({ id: categoryId, children: subCategoryOrder });
        });
        $("#orderInput").val(JSON.stringify(order));
    }

    function getSubCategoriesOrder($parent) {
        var order = [];
        $parent.find("> .sortable-subcategories > li").each(function() {
            var categoryId = $(this).data('id');
            var subCategoryOrder = getSubCategoriesOrder($(this));
            order.push({ id: categoryId, children: subCategoryOrder });
        });
        return order;
    }

    window.submitOrderForm = function() {
        updateOrder();
        $("#orderForm").submit();
    }
});
