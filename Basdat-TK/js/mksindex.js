var currentPage = 3;
var totalPage = 0;
var term;
var sort = $("#sort").val();
function getMks(data) {
    console.log("data", data);
    $.ajax({
        method: "GET",
        url: "../request/request.php",
        dataType: "JSON",
        data: data,
        success: function(response) {
            var table = $("#mkstable");
            var thead = table.find("thead");
            var tbody = table.find("tbody");
            console.log("get mks success", response);
            tbody.empty();
            totalPage = Math.floor(response.data.total);
            $("#pageNum").html("of " + totalPage);
            $.each(response.data.mkslist, function(i, item) {
                var mksItem = "<tr>";
                mksItem += "<td>" + item['idmks'] + "</td>";
                mksItem += "<td colspan='1'>" + item['judul'] + "</td>";
                mksItem += "<td>" + item['nama'] + "</td>";
                mksItem += "<td>" + item['tahun'] + "\n" + ((item['semester'] == 1) ? ("Gasal" + "</td>") : (item['semester'] == 2) ? "Genap" : "Pendek") + "</td>";
                mksItem += "<td>" + item['jenis'] + "</td>";
                mksItem += "<td><ul class='list-group'>" +
                    ((item['ijinmajusidang'] != null) ? "<li class='list-group-item list-group-item-success'> maju sidang </li> " : "") +
                    ((item['pengumpulanhardcopy'] != null) ? "<li class='list-group-item list-group-item-success'> kumpul hardcopy </li>" : "") +
                    ((item['issiapsidang'] != null) ? "<li class='list-group-item list-group-item-success'> siap sidang </li>" : "") +
                    "</ul></td>";
                mksItem += "</tr>";
                tbody.append(mksItem);
            });
        },
        error: function(err) {
            console.log("get mks error", err.responseText);
        }
    });
}

function getTerm() {
    $.ajax({
        url: "../request/request.php",
        method: "GET",
        dataType: "JSON",
        data: {
            "action": "GET_TERM"
        },
        success: function(response) {
            var data = response.data;
            var selectTerm = $("#selectTerm");
            selectTerm.empty();
            for (var i = 0; i < data.length; i++) {
                var semester = (data[i].semester == 1) ? 'Gasal' : (data[i].semester == 2) ? 'Genap' : 'Pendek';
                selectTerm.append('<option value="' + data[i].tahun + ' ' + data[i].semester + '">' + data[i].tahun + '/' + semester + '</option>');
            }
            term = selectTerm.val().split(" ");
            console.log("term", term);
        },
        error: function(err) {
            console.log("error : ", err.responseText);
        }
    });
}
$.when(getTerm()).then(function(){
    setTimeout(function(){
        $.when(getMks({
            action: "GET_MKS_WITH_TERM",
            skip: 0,
            take: 10,
            term : term,
            sort: sort
        })).then(function() {
            setTimeout(function(){
                console.log("load done", totalPage);
                pagination.empty();
                for (var i = 1; i <= totalPage; i++) {
                    var page = '<option value="' + i + '">' + i + '</option>';
                    pagination.append(page);
                }
            },500);

        });
    }, 10);

});
var pagination = $("#pagination");
pagination.change(function() {
    currentPage = $(this).val();
    showperpage = $("#showperpage").val();
    var data = {
        action: "GET_MKS_WITH_TERM",
        skip: currentPage * showperpage,
        take: showperpage,
        sort: sort,
        term : term
    };
    getMks(data);
});

$("#showperpage").change(function() {
    currentPage = pagination.val();
    showperpage = $(this).val();
    var data = {
        action: "GET_MKS_WITH_TERM",
        skip: currentPage * showperpage,
        take: showperpage,
        sort: sort,
        term : term
    };
    getMks(data);
});

$("#selectTerm").change(function(){
    term = $(this).val().split(" ");
	console.log(term);
    $.when(getMks({
        action: "GET_MKS_WITH_TERM",
        skip: 0,
        take: 10,
        sort: sort,
        term : term
    })).then(function() {
        console.log("load done", totalPage);
        pagination.empty();
        for (var i = 1; i <= totalPage; i++) {
            var page = '<option value="' + i + '">' + i + '</option>';
            pagination.append(page);
        }
    });
});

$("#sort").change(function() {
    sort = $(this).val();
    $.when(getMks({
        action: "GET_MKS_WITH_TERM",
        skip: 0,
        take: 10,
        sort: sort,
        term : term
    })).then(function() {
        console.log("load done", totalPage);
        pagination.empty();
        for (var i = 1; i <= totalPage; i++) {
            var page = '<option value="' + i + '">' + i + '</option>';
            pagination.append(page);
        }
    });
});
