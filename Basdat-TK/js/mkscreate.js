    var term;
    var dosenList;
    var dosenOption;

    // ajax call
    $.ajax({
        url: "../request/request.php",
        method: "GET",
        dataType: "JSON",
        data: {
            "action": "GET_TERM"
        },
        success: function(response) {
            var data = response.data;
            var selectTerm = $("#term");
            selectTerm.empty();
            for (var i = 0; i < data.length; i++) {
                var semester = (data[i].semester == 1) ? 'Gasal' : (data[i].semester == 2) ? 'Genap' : 'Pendek';
                selectTerm.append('<option value="' + data[i].tahun + ' ' + data[i].semester + '">' + data[i].tahun + '/' + semester + '</option>');
            }
            term = selectTerm.val().split(" ");
            getMahasiswaWithoutMKS(term);
        },
        error: function(err) {
            console.log("error : ", err.responseText);
        }
    });


    function getMahasiswaWithoutMKS(term) {
        console.log("term", term);
        $.ajax({
            url: "../request/request.php",
            method: "GET",
            dataType: "JSON",
            data: {
                action: "GET_MAHASISWA_WITHOUT_MKS_TERM",
                term : term
            },
            success: function(response) {
                console.log("response", response);
                var data = response.data;
                var selectMahasiswa = $("#mahasiswa");
                selectMahasiswa.empty();
                for (var i = 0; i < data.length; i++) {
                    selectMahasiswa.append('<option value=' + data[i].npm + '>' + data[i].nama + '</option>');
                }
            },
            error : function(err) {
                console.log("error", err.responseText);
            }
        });
    }

    $("#term").change(function() {
        term = $(this).val().split(" ");
        getMahasiswaWithoutMKS(term);
    });
    $.ajax({
        url: "../request/request.php",
        method: "GET",
        dataType: "JSON",
        data: {
            "action": "GET_JENIS_MKS"
        },
        success: function(response) {
            var data = response.data;
            var selectJenisMKS = $("#jenismks");
            selectJenisMKS.empty();
            for (var i = 0; i < data.length; i++) {
                selectJenisMKS.append('<option value=' + data[i].id + '>' + data[i].namamks + '</option>');
            }
        }
    });

    $.ajax({
        url: "../request/request.php",
        method: "GET",
        dataType: "JSON",
        data: {
            "action": "GET_DOSEN"
        },
        success: function(response) {
            dosenList = response.data;
            var pembimbing1 = $("#pembimbing1");
            var pembimbing2 = $("#pembimbing2");
            var pembimbing3 = $("#pembimbing3");
            var penguji = $("#penguji");
            for (var i = 0; i < dosenList.length; i++) {
                var option = '<option value=' + dosenList[i].nip + '>' + dosenList[i].nama + '</option>';
                dosenOption += option;
                pembimbing1.append(option);
                pembimbing2.append(option);
                pembimbing3.append(option);
                penguji.append(option);
            }
        }
    });


    var x = 1;
    var pengujiWrapper = $("#penguji-wrapper");
    $("#tambah-penguji").click(function() {
        if (x < 3) {
            x++;
            var defaultOption = "<option value='0'>Pilih Dosen</option>";
            var penguji = 'penguji' + x;
            var field = '<div class="form-group ">' +
                '<select class="form-control penguji" id="' + penguji + '" name="' + penguji + '">' + defaultOption + dosenOption +
                '</select>' +
                '</div>';
            pengujiWrapper.append(field);
        }
    });

    $("#remove-penguji").on("click", function(){
        if (x > 1) {
            $(".penguji").last().remove();
            x--;
        }
    });

    $(".pembimbing").change(function() {
        console.log("change");
        var prevValue = $(this).data('previous');
        $('.pembimbing').not(this).find('option[value="' + prevValue + '"]').show();
        var value = $(this).val();
        $(this).data('previous', value);
        $('.pembimbing').not(this).find('option[value="' + value + '"]').hide();
    });

    $(".penguji").change(function() {
        console.log("change");
        var prevValue = $(this).data('previous');
        $('.penguji').not(this).find('option[value="' + prevValue + '"]').show();
        var value = $(this).val();
        $(this).data('previous', value);
        $('.penguji').not(this).find('option[value="' + value + '"]').hide();
    });

    $("#term").change(function(){

    });
    $("#btnCreate").click(function(e) {
        var error = false;
        var term = $("#term").val().split(" ");
        var npm = $("#mahasiswa").val();
        var type = $("#jenismks").val();
        var title = $("#judulmks").val();
        if (title == null || title.length < 4) {
            error = true;
            $("#judulmks").parent().addClass("has-error");
        } else {
            $("#judulmks").parent().removeClass("has-error");
        }

        var adviserList = [];
        $(".pembimbing").each(function() {
            var value = $(this).val();
            if (value === "0") {
                error = true;
                $(this).parent().addClass("has-error");
            } else {
                $(this).parent().removeClass("has-error");
                adviserList.push(value);
            }
        });
        var examinerList = [];
        $(".penguji").each(function() {
            var value = $(this).val();
            if (value === "0") {
                error = true;
                $(this).parent().addClass("has-error");
            } else {
                $(this).parent().removeClass("has-error");
                examinerList.push(value);
            }

        });
        if (error) return;
        var id = randomId();
        data = {
            action: "CREATE_MKS",
            idmks: id,
            term: term,
            npm: npm,
            type: type,
            title: title,
            adviserlist: adviserList,
            examinerlist: examinerList,
        };
        console.log("data", data);
        $.ajax({
            url: "../request/request.php",
            dataType: "json",
            data: data,
            method: "POST",
            success: function(response) {
                console.log("sumbitted", response);
                window.location = "index.php";
            },
            error: function(data) {
                console.log("error", data.responseText);
                window.location = "home.php";
            }
        });
    });
