<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card mt-5">
              <div class="card-header">
                <h3 class="card-title"> All Users</h3>

                <div class="card-tools">
                   <button class="btn btn-success" data-toggle="modal"   data-target="#addNewModal" >Add New
                   <span><i class="fas fa-user-plus"></i></span>
                   </button>
                </div>
               
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Action</th>
                  </tr>
                  <tr>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td><span class="tag tag-success">Approved</span></td>
                    <td>
                      <a href="#">
                <i class="fas fa-edit"></i>

                      </a>|
                       <a href="#">
              <i class="fas fa-trash-alt"></i>

                      </a>
                    </td>
                  </tr>
                 
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNewModal">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit="createUser">
           <div class="modal-body">
                  <div class="form-group">
                     <label>Username</label>
                      <input v-model="form.name" type="text" name="name"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                       <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                     <label>Email</label>
                      <input v-model="form.email" type="text" name="email"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                       <has-error :form="form" field="email"></has-error>
                </div>
                   <div class="form-group">
                     <label>Bio</label>
                      <textarea v-model="form.bio" type="bio" name="bio"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                       <has-error :form="form" field="bio"></has-error>
                </div>
                 <div class="form-group">
    <label for="exampleFormControlSelect1">Example select</label>
    <select name="type" v-modal="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"> 
      <option value="">Select User Role</option>
      <option value ="admin">Admin</option>
      <option value ="admin">Standard User</option>
      <option value ="admin">Author</option>
      
    </select>
    <has-error :form="form" field="type"></has-error>
  </div>
            <div class="form-group">
                     <label>Password</label>
                      <input v-model="form.password" type="password" name="password"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                       <has-error :form="form" field="password"></has-error>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
     </form>
    </div>
   
  </div>

</div>
    </div>
</template>

<script>
    export default {

        data()
        {
            return{
                form:new Form({
                   name: '',
                   email: '',
                   password: '',
                   type: '',
                   bio: '',
                   photo: '',
                })
            }
        },
        methods:{
            createUser()
            {
                this.form.post('api/user');
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
