            <div class="content" style="margin-top: 20px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 ml-auto mr-auto text-center"></div>
                        <div class="col-md-6 ml-auto mr-auto text-center">
                            <ul style="max-width: fit-content;" class="max-width: fit-content; card nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                                <li class="nav-item">
                                      <a class="nav-link" href="users" role="tablist">
                                          <i class="material-icons">person</i>
                                          Users
                                      </a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="" role="tablist">
                                        <i class="material-icons">person_add</i>
                                        Create User
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="users/workhours/<?=date('Y-m');?>-1--<?=date('Y-m');?>-31" role="tablist">
                                        <i class="material-icons">access_time</i>
                                        Show Workhours
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3 ml-auto mr-auto text-center"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">
                                    <h4 class="title">Create User</h4>
                                    <p class="category">Creating new user</p>
                                </div>
                                <div class="card-content">
                                    <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Username</label>
                                                    <input type="text" required name="username" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Password</label>
                                                    <input type="password" required name="password" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Fist Name</label>
                                                    <input type="text" required name="first_name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" required name="last_name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Role</label>
                                                    <select  onchange="getSupervisors(this.value)" required name="role" class="form-control">
                                                        <option value=''></option>
                                                        <option value="operator">Operator</option>
                                                        <option value="supervisor">Supervisor</option>
                                                        <option value="floor_manager">Floor Manager</option>
                                                        <option value="economist">Economist</option>
                                                        <option value="backoffice">Backoffice</option>
                                                        <option value="formatore">Formatore</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="supervisorif">

                                            </div>
                                        </div>
                                        <input type="hidden" name="create_user">
                                        <button type="submit" class="btn btn-info pull-right">Create User</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $('.usersNav').addClass('active');

function getSupervisors(v){
    if (v=='operator') {
        $.ajax({
          url: '<?=URL;?>api/getSupervisors/',
          type: 'POST',
          dataType: 'json',
        })
        .done(function(data) {
            dataa=data;
            $('#supervisorif').html(`<div class="form-group label-floating">
                                                    <label class="control-label">Supervisor</label>
                                                    <select  id="supervisor" required name="supervisor" class="form-control">
                                                        <option value=''></option>
                                                    </select>
                                                </div>`);
            $('#supervisor').focus();
            for (var i=0;i<data.length;i++) {
               $('#supervisor').append('<option value='+data[i].user_id+'>'+data[i].full_name+'</option>');
            };
            $('#supervisorif').show();
        })
        .fail(function(err) {
            console.log(err);
        })
    }else{
        $('#supervisorif').html('');
        $('#supervisorif').hide();
    }

}
            </script>
