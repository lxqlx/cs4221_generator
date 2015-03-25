    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><span id = "cursive">CS4221 Realistic Data Set Generator</span></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
   

         <div class="col-xs-12 main">     
          <div class="well well-sm welcome">
            <p id="description">Are you bothered when you want some realistic data to test your programme?<br>
               Try our realistic data generator!!<br>
            </p>
          </div>
         </div>
         <?php echo validation_errors(); ?>
          <?php echo form_open('datagenerator'); ?>
          <div class="col-xs-12 main" id="country">
            <select class="selectpicker col-xs-12" title="Select countries" id="countries" name="countries[]" multiple >
              <optgroup data-icon="glyphicon-globe" label="East Asia">
                <option data-icon="glyphicon-grain">China</option>
                <option data-icon="glyphicon-grain">Japan</option>
                <option data-icon="glyphicon-grain">Korea</option>
              </optgroup>
              <optgroup data-icon="glyphicon-globe" label="South East Asia">
                <option data-icon="glyphicon-grain">Singapore</option>
                <option data-icon="glyphicon-grain">Malaysia</option>
                <option data-icon="glyphicon-grain">Indonesia</option>
                <option data-icon="glyphicon-grain">Vietnam</option>
              </optgroup>
              <optgroup data-icon="glyphicon-globe" label="South Asia">
                <option data-icon="glyphicon-grain">India</option>
              </optgroup>
              <optgroup data-icon="glyphicon-globe" label="Europe">
                <option data-icon="glyphicon-grain">United Kingdom</option>
              </optgroup>
            </select>
          </div>


          <div class="col-xs-12 main table-responsive" id="input"> 
            <table id="userinput" class="table-responsive"> 
              <thead>
                <tr>
                  <th> &nbsp Field Name </th>
                  <th> &nbsp Data Type </th>
                  <th> &nbsp Constrains </th>
                  <th> &nbsp Domain </th>
                  <th> </th>
                  <th> &nbsp Distribution</th>
                  <th> </th>
                </tr>
              <thead>
              <tbody>
                <tr id="1">
                    <td>
                        <input type="text" class="filedname form-control" id="fieldname1" name="fieldname1" placeholder="Enter field name" >
                    </td>
                    <td>
                        <select class="datatype form-control" id="datatype1" name="datatype1">
                        <optgroup label = "Regional">
                          <option value="namer">name_regional</option>
                          <option value="emailr">email_regional</option>
                          <option value="phoner">phone_regional</option>
                          <option value="country">country</option>
                        </optgroup>
                        <optgroup label = "Not Regional">
                          <option value="name">name</option>
                          <option value="email">email</option>
                          <option value="phone">phone</option>
                          <option value="gender">gender</option>
                          <option value="date"> date</option>
                          <option value="string">string</option>
                          <option value="integer"selected>integer</option>
                          <option value="float">float</option>
                        </optgroup>
                        </select>
                    </td>
                    <td>
                        <select class="constrain form-control" id="constrain1" name="constrain1">
                        <option value="primay">primary key</option>
                        <option value="unique">unique</option>
                        <option value="notnull">not null</option>
                        </select>
                    </td>
                    <td>
                       <input type="text" class="lowerbound form-control" id="lowerbound1" name="lowerbound1" placeholder="lower bound">
                    </td>
                    <td>
                       <input type="text" class="upperbound form-control" id="upperbound1" name="upperbound1" placeholder="upper bound">
                    </td>
                    <td>
                       <select class="distribution form-control" id="distribution1">
                        <option value="normal">normal distribution</option>
                        <option value="uniform" selected>uniform</option>
                       </select>
                       <input type="text" class="standarddeviation form-control" id="stanadarddeviation1" name"stanadarddeviation1" placeholder="standard deviation">                   
                    </td>
                    <td>
                      <button type="button" class="close" aria-label="Close" id="1"><span aria-hidden="true">&times;</span></button>
                    </td>
                </tr>
                <tr id="2">
                    <td>
                        <input type="text" class="filedname form-control" id="fieldname2" name="fieldname2" placeholder="Enter field name">
                    </td>
                    <td>
                        <select class="datatype form-control" id="datatype2" name="datatype2">
                        <optgroup label = "Regional">
                          <option value="namer">name_regional</option>
                          <option value="emailr">email_regional</option>
                          <option value="phoner">phone_regional</option>
                          <option value="country">country</option>
                        </optgroup>
                        <optgroup label = "Not Regional">
                          <option value="name">name</option>
                          <option value="email">email</option>
                          <option value="phone">phone</option>
                          <option value="gender">gender</option>
                          <option value="date"> date</option>
                          <option value="string">string</option>
                          <option value="integer" selected>integer</option>
                          <option value="float">float</option>
                        </optgroup>
                        </select>
                    </td>
                    <td>
                        <select class="constrain form-control" id="constrain2" name="constrain2">
                        <option value="primay">primary key</option>
                        <option value="unique">unique</option>
                        <option value="notnull">not null</option>
                        </select>
                    </td>
                    <td>
                       <input type="text" class="lowerbound form-control" id="lowerbound2" name="lowerbound2" placeholder="lower bound">
                    </td>
                    <td>
                       <input type="text" class="upperbound form-control" id="upperbound2" name="upperbound2" placeholder="upper bound">
                    </td>
                    <td>
                       <select class="distribution form-control" id="distribution2" name="distribution2">
                        <option value="normal">normal distribution</option>
                        <option value="uniform" selected>uniform</option>
                       </select>
                       <input type="text" class="standarddeviation form-control" id="stanadarddeviation2" name="stanadarddeviation2" placeholder="standard deviation">                    
                    </td>
                    <td>
                      <button type="button" class="close" aria-label="Close" id="2"><span aria-hidden="true">&times;</span></button>
                    </td>
                </tr>
                <tr id="3">
                    <td>
                        <input type="text" class="filedname form-control" id="fieldname3" name="fieldname3" placeholder="Enter field name">
                    </td>
                    <td>
                        <select class="datatype form-control" id="datatype3" name="datatype3">
                        <optgroup label = "Regional">
                          <option value="namer">name_regional</option>
                          <option value="emailr">email_regional</option>
                          <option value="phoner">phone_regional</option>
                          <option value="country">country</option>
                        </optgroup>
                        <optgroup label = "Not Regional">
                          <option value="name">name</option>
                          <option value="email">email</option>
                          <option value="phone">phone</option>
                          <option value="gender">gender</option>
                          <option value="date"> date</option>
                          <option value="string">string</option>
                          <option value="integer"selected>integer</option>
                          <option value="float">float</option>
                        </optgroup>
                        </select>
                    </td>
                    <td>
                        <select class="constrain form-control" id="constrain3" name="constrain3">
                        <option value="primay">primary key</option>
                        <option value="unique">unique</option>
                        <option value="notnull">not null</option>
                        </select>
                    </td>
                    <td>
                       <input type="text" class="lowerbound form-control" id="lowerbound3" name="lowerbound3" placeholder="lower bound">
                    </td>
                    <td>
                       <input type="text" class="upperbound form-control" id="upperbound3" name="upperbound3" placeholder="upper bound">
                    </td>
                    <td>
                       <select class="distribution form-control" id="distribution3">
                        <option value="normal">normal distribution</option>
                        <option value="uniform" selected>uniform</option>
                       </select>
                       <input type="text" class="standarddeviation form-control" id="stanadarddeviation3" name="stanadarddeviation3" placeholder="standard deviation">                 
                    </td>
                    <td>
                      <button type="button" class="close" aria-label="Close" id="3"><span aria-hidden="true">&times;</span></button>
                    </td>
                </tr>
                <tr id="4">
                    <td>
                        <input type="text" class="filedname form-control" id="fieldname4" name="fieldname4" placeholder="Enter field name">
                    </td>
                    <td>
                        <select class="datatype form-control" id="datatype4" name="datatype4">
                        <optgroup label = "Regional">
                          <option value="namer">name_regional</option>
                          <option value="emailr">email_regional</option>
                          <option value="phoner">phone_regional</option>
                          <option value="country">country</option>
                        </optgroup>
                        <optgroup label = "Not Regional">
                          <option value="name">name</option>
                          <option value="email">email</option>
                          <option value="phone">phone</option>
                          <option value="gender">gender</option>
                          <option value="date"> date</option>
                          <option value="string">string</option>
                          <option value="integer" selected>integer</option>
                          <option value="float">float</option>
                        </optgroup>
                        </select>
                    </td>
                    <td>
                        <select class="constrain form-control" id="constrain4" name="constrain4">
                        <option value="primay">primary key</option>
                        <option value="unique">unique</option>
                        <option value="notnull">not null</option>
                        </select>
                    </td>
                    <td>
                       <input type="text" class="lowerbound form-control" id="lowerbound4" name="lowerbound4" placeholder="lower bound">
                    </td>
                    <td>
                       <input type="text" class="upperbound form-control" id="upperbound4" name="upperbound4" placeholder="upper bound">
                    </td>
                    <td>
                       <select class="distribution form-control" id="distribution4">
                        <option value="normal">normal distribution</option>
                        <option value="uniform" selected>uniform</option>
                       </select>
                       <input type="text" class="standarddeviation form-control" id="stanadarddeviation4" name="stanadarddeviation4" placeholder="standard deviation">                    
                    </td>
                    <td>
                      <button type="button" class="close" aria-label="Close" id="4"><span aria-hidden="true">&times;</span></button>
                    </td>
                </tr>
              </tbody>           
            </table>
          </div>  
          
          <div class="col-xs-12">
            <button type="button" class="btn btn-primary active" id = "add">
              <span id="description">Add a row</span>
            </button>
          </div>
      

        <div class="col-xs-12 main" id = "generate">
            <div class="form-group">
              <label for="exampleInputEmail2">#Rows: </label>
              <input type="text" class="form-control" id="rows" name="rows" placeholder="Enter an integer">  
            </div>
            <div class="form-group">
              <label for="exampleInputEmail2">Output Formats: </label>
              <select class="form-control">
                      <option>CSV</option>
              </select> 
            </div>
            <button type="submit" class="btn btn-default">Generate</button>
          
        </div>
      </form>
        
        
     
    </div>


    <script>
          var size = 4;
          
          

           $( document ).ready(function() {
            $('#add').on("click",function(){
               size ++;
               var newRow = '<tr id="'+size+'">'+
                    '<td>'+
                        '<input type="text" class="filedname form-control" id="fieldname'+size+'" name="fieldname'+size+'" placeholder="Enter field name">'+
                    '</td>'+
                    '<td>'+
                        '<select class="datatype form-control" id="datatype'+size+'" name="datatype'+size+'">'+
                        '<optgroup label = "Regional">'+
                          '<option value="namer">name_regional</option>'+
                          '<option value="emailr">email_regional</option>'+
                          '<option value="phoner">phone_regional</option>'+
                          '<option value="country">country</option>'+
                        '</optgroup>'+
                        '<optgroup label = "Not Regional">'+
                          '<option value="name">name</option>'+
                          '<option value="email">email</option>'+
                          '<option value="phone">phone</option>'+
                          '<option value="gender">gender</option>'+
                          '<option value="date"> date</option>'+
                          '<option value="string">string</option>'+
                          '<option value="integer" selected>integer</option>'+
                          '<option value="float">float</option>'+
                        '</optgroup>'+
                        '</select>'+
                    '</td>'+
                    '<td>'+
                        '<select class="constrain form-control" id="constrain'+size+'" name="constrain'+size+'">'+
                        '<option value="primay">primary key</option>'+
                        '<option value="unique">unique</option>'+
                        '<option value="notnull">not null</option>'+
                        '</select>'+
                    '</td>'+
                    '<td>'+
                       '<input type="text" class="lowerbound form-control" id="lowerbound'+size+'" name="lowerbound'+size+'" placeholder="lower bound">'+
                    '</td>'+
                    '<td>'+
                       '<input type="text" class="upperbound form-control" id="upperbound'+size+'" name="upperbound'+size+'" placeholder="upper bound">'+
                    '</td>'+
                    '<td>'+
                       '<select class="distribution form-control" id="distribution'+size+'" name="distribution'+size+'">'+
                        '<option value="normal">normal distribution</option>'+
                        '<option value="uniform" selected>uniform</option>'+
                       '</select>'+ 
                       '<input type="text" class="standarddeviation form-control" id="stanadarddeviation'+size+'" name="stanadarddeviation'+size+'" placeholder="standard deviation">'+              
                    '</td>'+
                    '<td>'+
                      '<button type="button" class="close" aria-label="Close" id="'+size+'"><span aria-hidden="true">&times;</span></button>'+
                    '</td>'+
                '</tr>';
              $('#userinput tbody').append(newRow);
            });
           });

            function assignID()
            {
              for (var i = 0; i <size; i++) {
               $('#userinput tbody tr:eq('+i+')').attr("id",i+1);
               $('#userinput tbody tr:eq('+i+') .close').attr("id",i+1);
               $('#userinput tbody tr:eq('+i+') .datatype').attr("id","datatype"+(i+1));
               $('#userinput tbody tr:eq('+i+') .constrain').attr("id","constrain"+(i+1));
               $('#userinput tbody tr:eq('+i+') .lowerbound').attr("id","lowerbound"+(i+1));
               $('#userinput tbody tr:eq('+i+') .upperbound').attr("id","upperbound"+(i+1));
               $('#userinput tbody tr:eq('+i+') .distribution').attr("id","distribution"+(i+1));
               $('#userinput tbody tr:eq('+i+') .fieldname').attr("id","fieldname"+(i+1));
              }
            }
            
            $(document).ready(function() {
            $(document).on("click",".close",function(){
              size --;
              var rowId = $(this).attr("id");
              $("#userinput tr#"+rowId).remove();
              assignID();
            });
           });

            $(document).ready(function() {
              $(document).on("change", "select.datatype",function(){
                var dtype = $(this).val();
                var idstring = $(this).attr("id");
                var id = idstring[8];
                if (dtype != "float"&&dtype != "integer"&&dtype != "date") {
                  $( "#upperbound"+id).prop("disabled", true);
                  $( "#lowerbound"+id).prop("disabled", true);
                  $( "#distribution"+id).prop("disabled", true);
                }
                else
                {
                  $( "#upperbound"+id).prop("disabled", false);
                  $( "#lowerbound"+id).prop("disabled", false);
                  $( "#distribution"+id).prop("disabled", false);
                }
              });
            });

            $(document).ready(function() {
              $(document).on("change", "select.distribution",function(){
                var dtype = $(this).val();
                var idstring = $(this).attr("id");
                var id = idstring[12];
                if (dtype == "normal") {
                  $( "#stanadarddeviation"+id).css("visibility", "visible");
                  $( "#stanadarddeviation"+id).css("display", "inline");
                }
                else{
                  $( "#stanadarddeviation"+id).css("visibility", "hidden");
                  $( "#stanadarddeviation"+id).css("display", "none");
                }
              });
            });

            $(document).ready(function() {
              $(document).on("change", "select.datatype",function(){
                var dtype = $(this).val();
                var idstring = $(this).attr("id");
                var id = idstring[8];
                if (dtype == "date") {
                  $('#lowerbound'+id).datepicker({
                    format: 'mm/dd/yyyy',
                    todayHighlight: true
                   });
                  $('#upperbound'+id).datepicker({
                    format: 'mm/dd/yyyy',
                     todayHighlight: true
                   });
                  $('#lowerbound'+id).prop("readonly",true);
                  $('#upperbound'+id).prop("readonly",true);
                }
                else{
                  $('#lowerbound'+id).prop("readonly",false);
                  $('#upperbound'+id).prop("readonly",false);
                  $('#upperbound'+id).val(" ");
                  $('#lowerbound'+id).val(" ");
                  $('#lowerbound'+id).datepicker('remove');
                  $('#upperbound'+id).datepicker('remove');
                }
              });
            });
    </script>
