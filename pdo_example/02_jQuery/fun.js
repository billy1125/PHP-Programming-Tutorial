$("#student_data_list").ready(function () {
    $.ajax({
        type: "GET",
        url: "access_db.php?function=Query_All_Students",
        dataType: "json",
        success: function (data) {
            for (let i = 0; i < data.length; i++) {
                const item = data[i];
                $("#student_data_list").append("<tr><td>" + item['id'] + "</td>" +
                    // "<td><a href='access_db.php?function=Delete_One_Student&id=" + item['id'] + "'>刪</a></td>" +
                    "<td><input type='button' value='刪除' onclick='btn_click(" + item['id'] + ")'' /></td>" +
                    "<td><a href='update_form.html?id=" + item['id'] + "'>" + item['name'] + "</td>" +
                    "<td>" + item['gender'] + "</td></tr>");
            }
        },
        error: function (jqXHR) {
            console.log("發生錯誤: " + jqXHR.status);
        }
    })
});

function btn_click(_id) {
    $.ajax({
        type: "POST",
        url: "access_db.php?function=Delete_One_Student&id=" + _id,
        dataType: "html",
        data: $("#insert_form").serialize(),
        success: function (data) {
            alert(data)
            location.reload()
        },
        error: function (jqXHR) {
            console.log("發生錯誤: " + jqXHR.status)
        }
    })
}

$("#update_form").ready(function () {
    let student_id = ""
    let searchParams = new URLSearchParams(window.location.search)
    if (searchParams.has('id')) {
        student_id = searchParams.get('id')
    }

    $.ajax({
        type: "GET",
        url: "access_db.php?function=Query_One_Student&id=" + student_id,
        dataType: "json",
        success: function (data) {
            $("#name").val(data['name'])
            $("#gender").val(data['gender'])
            $("#id").val(data['id'])
        },
        error: function (jqXHR) {
            console.log("發生錯誤: " + jqXHR.status)
        }
    })

    $("#update_form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "access_db.php?function=Update_One_Student",
            dataType: "html",
            data: $("#update_form").serialize(),
            success: function (data) {
                alert(data)
                window.location.assign("index.html")
            },
            error: function (jqXHR) {
                console.log("發生錯誤: " + jqXHR.status)
            }
        })
    });
});

$("#insert_form").ready(function () {
    $("#insert_form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "access_db.php?function=Insert_One_Student",
            dataType: "html",
            data: $("#insert_form").serialize(),
            success: function (data) {
                alert(data)
                window.location.assign("index.html")
            },
            error: function (jqXHR) {
                console.log("發生錯誤: " + jqXHR.status)
            }
        })
    });
});