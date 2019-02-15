<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card mt-5">
              <div class="card-header">
                <h3 class="card-title"> All Users</h3>

                <div class="card-tools">
                   <button class="btn btn-success" @click="newModel" >Add New
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
                    <th>Registared At</th>
                    <th>Action</th>
                  </tr>
              
                    <tr v-for="item in users" :key="item.id">
                    <td>{{item.id}}</td>
                    <td>{{item.name}}</td>
                    <td>{{item.email}}</td>
                    <td>{{item.type | upText}}</td>
                    <td>{{item.created_at |dateFormat}}</td>

                    <td><span class="tag tag-success">Approved</span></td>
                    <td>
                      <a href="#" @click="editModel(item)">
                <i class="fas fa-edit"></i>

                      </a>|
                       <a href="#" @click="deleteUser(item.id)">
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
        <h5 class="modal-title" v-show="!editMode" id="addNewModal">Add New</h5>
        <h5 class="modal-title" v-show="editMode" id="addNewModal">Update User's Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editMode ? updateUser():createUser()">
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
                   <select name="type" v-model="form.type" id="type" class="form-control"
                     :class="{ 'is-invalid': form.errors.has('email') }"> 
                    <option value="">Select User Role</option>
                   <option value ="admin">Admin</option>
                     <option value ="user">Standard User</option>
                       <option value ="author">Author</option>
      
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
        <button v-show="editMode" type="submit"  class="btn btn-success">Update</button>
        <button v-show="!editMode" type="submit"  class="btn btn-primary">Create</button>
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
              editMode:false,
               users :{},
                form:new Form({
                    id:'',
                   name: '',
                   email: '',
                   password: '',
                   type: '',
                   bio: '',
                   photo: ''
                })
            }
        },
        methods:{
            updateUser(){
              //  console.log('editing data');
                this.$Progress.start();
               this.form.put('api/user/'+this.form.id)
               .then(()=>{
                 $('#addNewModal').modal('hide');
                    swal("yes! Your file has been updated!", {
                   icon: "success",
      
                    }
    
                   );
                 this.$Progress.finish();
                Fire.$emit('AfterCreate');

               }).catch(()=>{
                 this.$Progress.fail();
               });
            },
            editModel(user){
               this.editMode=true;
             $('#addNewModal').modal('show');
              this.form.fill(user);
          },
          newModel(){
            this.editMode=false;
            this.form.reset();
             $('#addNewModal').modal('show');
             
             
          },
          
            deleteUser(id)
           {
             swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this imaginary file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  this.form.delete('api/user/'+id).then(()=>{
    if (willDelete) {
    swal("Poof! Your imaginary file has been deleted!", {
      icon: "success",
      
    }
    
    );
    Fire.$emit('AfterCreate');
  }
  }).catch(()=>{
    swal("Failed!","There was something wrong. ", "warning");
  })
   
});
           },

          loadUsers(){
                axios.get("api/user").then(({data})=>(this.users=data.data))
          },
            createUser()
            {
              this.$Progress.start();
                this.form.post('api/user')
                .then(()=>{
 
                Fire.$emit('AfterCreate');
                $('#addNewModal').modal('hide')
                swal("Good job!", "You created User Successfully", "success");
                 this.$Progress.finish();
  
                
                })
                .catch(()=>{

                })
               
            }
        },
        created() {
            this.loadUsers();
            Fire.$on('AfterCreate',()=>{
             this.loadUsers();
            }); 
            // setInterval(()=>this.loadUsers(),3000);


        }
    }
</script>
