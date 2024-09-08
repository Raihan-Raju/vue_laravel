<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Category/</span>Item</h4>

        <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Category Update {{ id }} </h5>
                    
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Name</label>
                                <input v-model="name" type="text" class="form-control" id="basic-default-fullname"
                                    placeholder="Category Name" />
                            </div>
                            <button @click="updateCategory()" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
    </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {

    data() {
        return{
            name:'',
            id: this.$route.params.id,
        }
    },
    methods: {

        getCategory(){
            axios.get("http://127.0.0.1:8000/api/admin/categorys/" + this.id + '/edit').then((res) => {
                const categorys = res.data.data;
                this.name =categorys.name
                
            });
        },
        updateCategory(){
            const categoryData = {
                 name: this.name,
            }
            axios.put("http://127.0.0.1:8000/api/admin/categorys/"+this.id, categoryData)
                .then((response) => {
                    console.log(response);
                    this.$router.push('/admin/categorylist');

                });
        }
        
        },
        mounted() {
             this.getCategory();
            
        }
    }


</script>