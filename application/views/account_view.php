<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Management System</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head> 
<body>
    <div class="container">
        <h1 style="font-size:20pt">Account Management System</h1> 

        <br />
       <div class="form">
                <form action="#" id="form1" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Account Number</label>
                            <div class="col-md-9">
                                <input name="account_number" id="account_number" placeholder="Account Number" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <label class="control-label col-md-3">&nbsp;</label>
                            <div class="col-md-9">
                                 <button type="button" id="btnSearch" onclick="search()" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
        </div>
        <div id="showData"></div>
         <div id="showData1"></div>
         <button class="btn btn-success" onclick="add_account()" style="display:none;" id="show_add_button"><i class="glyphicon glyphicon-plus"></i> Add Account</button>
        <div id="content_list" style="display:none">
        
       
        
        </div>
    </div>

<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>


<script type="text/javascript">

var save_method; //for save method string
var table;
var base_url = '<?php echo base_url();?>';


function search(){

	var account_number = $('#account_number').val();
	$.ajax({
        url : base_url+'/account/ajax_get_account/',
        type: "POST",
        data: $('#form1').serialize(),
        success: function(data)
        {
        	get_account_numbers(account_number);
        }
    ,
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');


        }
    });

	
}

function get_account_numbers(account_number){
	$.ajax({
        url : base_url+'/account/ajax_get_account_numbers/',
        type: "POST",
        data: {'account_number':account_number},
        dataType: "JSON",
        success: function(data)
        {
        	// EXTRACT VALUE FOR HTML HEADER. 
        // ('Book ID', 'Book Name', 'Category' and 'Price')
        var col = [];
        for (var i = 0; i < data.length; i++) {
            for (var key in data[i]) {
                if (col.indexOf(key) === -1) {
                    col.push(key);
                }
            }
        }

        // CREATE DYNAMIC TABLE.
        var table = document.createElement("table");
        table.className = "table table-striped table-bordered";

        // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

        var tr = table.insertRow(-1);                   // TABLE ROW.

        for (var i = 0; i < col.length; i++) {
            var th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML = col[i];
            tr.appendChild(th);
        }

        // ADD JSON DATA TO THE TABLE AS ROWS.
        for (var i = 0; i < data.length; i++) {

            tr = table.insertRow(-1);

            for (var j = 0; j < col.length; j++) {
                var tabCell = tr.insertCell(-1);
                if(j==1){
                var ind_number=data[i][col[j]];
                	tabCell.innerHTML = '<a href="#" onclick="get_fnf_numbers('+ind_number+')">'+data[i][col[j]]+'</a>';
                }else{
                tabCell.innerHTML = data[i][col[j]];
                }
            }
             //tabCell.innerHTML ="aa";
        }

        // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
        var divContainer = document.getElementById("showData");
        
        divContainer.innerHTML = "";
        divContainer.appendChild(table);
        }
    ,
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');


        }
    });
}
function get_fnf_numbers(phone_number){
	$("#number").val(phone_number);
	$.ajax({
        url : base_url+'/account/ajax_get_fnf_numbers/',
        type: "POST",
        data: {'phone_number':phone_number},
        dataType: "JSON",
        success: function(data)
        {
        //alert(data.length);
        console.log(data.length);
        	// EXTRACT VALUE FOR HTML HEADER. 
        // ('Book ID', 'Book Name', 'Category' and 'Price')
        var col = [];
        for (var i = 0; i < data.length; i++) {
            for (var key in data[i]) {
                if (col.indexOf(key) === -1) {
                    col.push(key);
                }
            }
        }

        // CREATE DYNAMIC TABLE.
        var table = document.createElement("table");
        table.className = "table table-striped table-bordered";

        // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

        var tr = table.insertRow(-1);                   // TABLE ROW.

        for (var i = 0; i < col.length; i++) {
            var th = document.createElement("th");      // TABLE HEADER.
            th.innerHTML = col[i];
            tr.appendChild(th);
        }

        // ADD JSON DATA TO THE TABLE AS ROWS.
        for (var i = 0; i < data.length; i++) {

            tr = table.insertRow(-1);

            for (var j = 0; j < col.length; j++) {
                var tabCell = tr.insertCell(-1);
                if(j==0){
                	var ind_number1=data[i][col[j]];
                	tabCell.innerHTML = '<a href="#" onclick="edit_account('+ind_number1+','+phone_number+')">'+data[i][col[j]]+'</a>';
                }else{
                tabCell.innerHTML = data[i][col[j]];
                }
                
            }
        }

        // FINALLY ADD THE NEWLY CREATED TABLE WITH JSON DATA TO A CONTAINER.
        var divContainer = document.getElementById("showData1");
        divContainer.innerHTML = "";
        divContainer.appendChild(table);
        $('#show_add_button').show();
        }
    ,
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
           

        }
    });
}
function add_account()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add account'); // Set Title to Bootstrap modal title


}

function edit_account(id,phone_number)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
	$('#fnf_id').val(id);
	$("#number").val(phone_number);
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('account/ajax_edit')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="provider"]').val(data.provider);
            $('[name="fnf_number"]').val(data.fnf_number);
            $('[name="status"]').val(data.status);
           
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit account'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('account/ajax_add')?>";
    } else {
        url = "<?php echo site_url('account/ajax_update')?>";
    }

    // ajax adding data to database

    var formData = new FormData($('#form')[0]);
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                //alert("num = "+$("#number").val());
                get_fnf_numbers($("#number").val());
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

			
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}


</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">FNF Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Phone Number</label>
                            <div class="col-md-9">
                                <input name="fnf_number" placeholder="FNF Phone Number" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Service Provider</label>
                            <div class="col-md-9">
                                <select name="provider" class="form-control">
                                   <option value="">--Select Operator--</option>
                                    <?php foreach($providers as $each){ ?>
        <option value="<?php echo $each->id; ?>"><?php echo $each->name; ?></option>';
    <?php } ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                               <select name="status" class="form-control">
                                    <option value="">--Select Status--</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                   
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                       
                    </div>
                    <input type="hidden" name="number" id="number" value="" />
                    <input type="hidden" name="fnf_id" id="fnf_id" value="" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


</body>
</html>