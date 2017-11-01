<script>
    // Add smooth scrolling to all links in navbar + footer link
    $(document).ready(function() {
        $("#up_arrow").on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 1000, function(){
                    window.location.hash = hash;
                });
            }
        });
    });

    // Manage which column to be a criterian for sorting table
    // Make tables to be responsive in any screen size
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            "order": [[ 12, "asc" ]],
            responsive: true
        });
    });

    // On mobile screen, it helpes show navigation bar when the button is clicked
    $(document).ready(function() {
        $('#menu_icon').on('click', function() {
            $('.header nav ul').toggleClass('show');
        });
    });

    // This makes the footer located at the bottom of page all the Times
    // $(document).ready(function() {
    //     $('.footer').css('margin-top', $(document).height() - ($('.primary').height() + $('.footer').height()) - 200);
    // });

    $(document).ready(function() {
        $('#ResponsiveTable td').html().replace('12', 'abc');
        // $('#ResponsiveTable td a').html().replace('', '.');
    });

    $('#ResponsiveTable td a').keyup(function() {
        var replaceSpace = $(this).val();
        var result = replaceSpace.replace(/ /g, ".");
        $("#ResponsiveTable td a").val(result);

    });

    // $("#ResponsiveTable td a").text(function () {
    //     return $(this).text().replaceAll("12", "aaa");
    // });​​​​​

    // When admin wansts to edit price a user's salary in invoice_detail.php
    // function editPrice() {
    //     document.getElementById("edit_price").innerHTML = "";
    //     document.getElementById("edit_price").outerHTML = document.getElementById("edit_price").outerHTML.replace(/div/g,"input");
    // }

    $("#theDate").val(getFormattedDate(new Date()));
    // $('#theDate').attr('value', today());
    // $("#theTomorrow").val(getFormattedDate(tomorrow()));
    // $("#theAnyDate").val(getFormattedDate(new Date("4/1/12")));

    // function today() {
    //     return new Date();
    // }

    // function tomorrow() {
    //     return today().getTime() + 24 * 60 * 60 * 1000;
    // }

    // Get formatted date YYYY-MM-DD
    function getFormattedDate(date) {
        return date.getFullYear() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2);
    }





    // Make it possible add a new row for description, qty, and price by pushing enter button 
    // Give focus at the description section after adding.
    $(document).ready(function(){
        $('#new_price, #new_description, #new_quantity').keypress(function(e){
            if(e.keyCode == 13) {
                $('#new_description').focus();
                $('#new_add').click();
            }
        });
    });

    // It's used when removing a row which is already added, asking if the decision is final
    function deleteBtn(val) {
        var result = confirm("Are you sure you want to remove it?");
        if (result == true) {
            location.href = "remove_estimate.php?id=" + val;
        }
    }

    // It's used when editing row before making pdf files.
    function edit_row(no) {
        document.getElementById('edit_button' + no).style.display = 'none';
        document.getElementById('save_button' + no).style.display = 'block';

        var description = document.getElementById('description_row' + no).getElementsByClassName('lineBreak')[0];
        var quantity = document.getElementById('quantity_row' + no).getElementsByClassName('lineBreak')[0];
        var price = document.getElementById('price_row' + no).getElementsByClassName('lineBreak')[0];

        var description_data = description.innerHTML;
        var quantity_data = quantity.innerHTML;
        var price_data = price.innerHTML;

        description.innerHTML = "<input class='form-control' type='text' id='description_text" + no + "' value='" + description_data + "'>";
        quantity.innerHTML = "<input class='form-control' type='text' id='quantity_text" + no + "' value='" + quantity_data + "'>";
        price.innerHTML = "<input class='form-control' type='text' id='price_text" + no + "' value='" + price_data+"'>";
    }

    function save_row(no) {
        var description_val = document.getElementById('description_text' + no).value;
        var quantity_val = document.getElementById('quantity_text' + no).value;
        var price_val = document.getElementById('price_text' + no).value;

        document.getElementById("description_row" + no).getElementsByClassName('lineBreak')[0].innerHTML = description_val;
        document.getElementById("quantity_row" + no).getElementsByClassName('lineBreak')[0].innerHTML = quantity_val;
        document.getElementById("price_row" + no).getElementsByClassName('lineBreak')[0].innerHTML = price_val;

        document.getElementById("edit_button" + no).style.display = "block";
        document.getElementById("save_button" + no).style.display = "none";
    }

    function delete_row(no) {
        var result = confirm("Are you sure you want to remove it?");
        if (result == true) {
            document.getElementById('row' + no).outerHTML = "";
        }
    }

    function add_row(no) {
        if (no == null)
            no = 0;
        var new_description = document.getElementById('new_description').value;
        var new_quantity = document.getElementById('new_quantity').value;
        var new_price = document.getElementById('new_price').value;

        var table = document.getElementById('data_table');
        var table_len = (table.rows.length) - 1 + no;
        var row = table.insertRow(table_len).outerHTML = 
        "<tr id='row"+table_len+"'><td id='description_row"+table_len+"'><div class='lineBreak'>"
        +new_description+"</div></td><td id='quantity_row"+table_len+"'><div class='lineBreak'>"
        +new_quantity+"</div></td><td id='price_row"+table_len+"'><div class='lineBreak'>"
        +new_price+"</div></td><td><div class='btn-group'><button type='button' class='btn btn-primary btn-xs dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></button><ul class='dropdown-menu' role='menu'><li><a id='edit_button"+table_len+"' class='edit' onclick='edit_row("+table_len+")'>Edit</a></li><li><a id='save_button"+table_len+"' class='save' onclick='save_row("+table_len+")'>Save</a></li><li><a class='delete' onclick='delete_row("+table_len+")'>Delete</a></li></ul></div></td></tr>";

        document.getElementById("new_description").value="";
        document.getElementById("new_quantity").value="";
        document.getElementById("new_price").value="";

        document.getElementById('save_button' + no).style.display = 'block';
    }

    function pass_data(num, path, typeBtn) {
        var oForm = document.forms["info"];
        var s = "";
        if (num > 1) {
            if (oForm.elements["po"].value.length > 0) {
                s += oForm.elements["po"].value + "\\";
            } else {
                s += "-\\";
            }
            if (oForm.elements["company"].value.length > 0) {
                s += oForm.elements["company"].value + "\\";
            } else {
                s += "-\\";
            }
            if (oForm.elements["apt"].value.length > 0) {
                s += oForm.elements["apt"].value + "\\";
            } else {
                s += "-\\";
            }
            if (oForm.elements["unit"].value.length > 0) {
                s += oForm.elements["unit"].value + "\\";
            } else {
                s += "-\\";
            }
            if (oForm.elements["size"].value.length > 0) {
                s += oForm.elements["size"].value + "\\";
            } else {
                s += "-\\";
            }
            if (num == 7) {
                if (oForm.elements["manager"].value.length > 0) {
                    s += oForm.elements["manager"].value + "\\";
                } else {
                    s += "-\\";
                }
            }
            if (typeBtn != 3) {
                s += oForm.elements["date"].value + "\\";
            }
        }
        var table = document.getElementById('data_table');
        // console.log(table);
        var rowLength = table.rows.length;
        // console.log(rowLength);
        $p = 0;
        if (typeBtn == 3) {
            $p = 1;
        }
        // console.log(table.rows.item(2).cells.item(0).getElementsByClassName('lineBreak')[0].innerHTML);
        // console.log(table.rows.item(0).cells.item(1));
        for (i = 1 + $p; i < rowLength - 1 + $p; i++) {
            var oCells = table.rows.item(i).cells;
            // console.log(table.rows.item(i).cells);
            //loops through each cell in current row
            for(var j = 0; j < 3; j++) {
                var cellVal = oCells.item(j).getElementsByClassName('lineBreak')[0].innerHTML; 
                if (cellVal.length > 0) {
                    s += cellVal;
                } else {
                    s += "-";
                }
                s += "\\";
            }   
        }

        // From worksheet_add.php, edit_admin.php
        if (typeBtn == 1) {
            window.location.href = path + "?json=" + s;
        }

        // From estimate_info.php
        if (typeBtn == 2) {
            window.open(path + "?json=" + s, '_blank');   
        }

        // It's currently on testing
        // From worksheet_add.php, edit_admin.php
        if (typeBtn == 3) {
            window.location.href = path + "?json=" + s;
        }
    }
</script>
