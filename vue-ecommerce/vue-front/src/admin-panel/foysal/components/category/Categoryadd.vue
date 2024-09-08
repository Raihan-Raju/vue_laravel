<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Customer/</span> Category</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Category</h5>
                        <small class="text-muted float-end">Default label</small>
                    </div>
                    <div class="card-body">
                       
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Name</label>
                                <input v-model="name" type="text" class="form-control" id="basic-default-fullname"
                                    placeholder="Category Name" />
                            </div>
                            
                            <button @click="savecategory" type="submit" class="btn btn-primary">submit</button>
                     
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {

    name:'Categoryadd',

    data(){
        
        return{
                name:'',
             }
        },
    
        methods: {
            savecategory(){
                const  categoriesData = {
                       name: this.name,
                }
                console.log ('ok')

                 axios.post('http://127.0.0.1:8000/api/admin/categorys/',categoriesData )
                    .then((res) => {
                        console.log(res)
                        this.$router.push('/admin/categorylist');
                    });
                 
            }
        },
        mounted(){
           
        }
    }

</script>