<template>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Add Sub_category</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label" for="basic-default-email">Category</label>
            <select class="form-select" v-model="category_id">
                <option selected>Open this select menu</option>
                <option v-for="(c, i) in category" :key="i" :value="c.id">{{ c.name }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">name</label>
            <input v-model="name" type="text" class="form-control" id="basic-default-fullname"
                placeholder="Sub category name" />
        </div>
        <button @click="saveSub_category" type="submit" class="btn btn-primary">Submit</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
     data() {
        return {
            category:[],
            category_id:0,
            name:''  
        }
    },
    methods: {
        getCategory(){
            axios.get("http://127.0.0.1:8000/api/admin/categorys")
            .then((result) =>{
                this.category = result.data.data;
                console.log(this.category)
            })
        },
        saveSub_category(){
            const subcategory = {
                category_id:this.category_id,
                name:this.name
            }
            console.log('ok');
            
            axios.post("http://127.0.0.1:8000/api/admin/subcategorys", subcategory)
            .then((res) => {
                console.log(res);
                this.$router.push('/admin/sub_category/sub_list');
            })
        }
    },
    mounted(){
        this.getCategory();
    }
}
</script>