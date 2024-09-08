<script>
import axios from 'axios';
import { v4 as uuidv4 } from 'uuid';
export default {
    data() {
        return {
            url: this.$store.state.base.url+"admin/",
            invoice_number: "",
            date: new Date().toISOString().slice(0, 16),
            user_id: "",
            total_price: "",
            vendorList: [],
            products: [],
            items: [],
            grandTotal:0,
        }
    },
    methods: {
        getQuantity(event) {
            const quantity = (event.target.value);
            //quantity= this.item.totalPrice
            console.log(this.items);
        },
        addProduct(event) {
            const id = parseInt(event.target.value);
            const selectedProduct = this.products.find(product => product.id === id);
            const itemExists = this.items.find(item => item.product_id === id);
            if (selectedProduct && !itemExists) {
                this.items.push({
                    product_id: id,
                    product_name: selectedProduct.name,
                    unit: 1,
                    quantity: 1,
                    price: selectedProduct.price,
                    totalPrice: selectedProduct.price * 1,
                })
            }
            this.getTotalPrice()
        },
        removeItem(index) {
            this.items.splice(index, 1);
            this.getTotalPrice();
        },
        getProducts() {
            axios.get(this.url + "products")
                .then((result) => {
                    this.products = result.data.data[0];
                })
                .catch(error => {
                    console.error("There was an error fetching the products:", error);
                });
        },
        // ===============Generate a new UUID as the invoice number======================
        invoiceNum() {
            const invoice = "INV:" + new Date().getTime().toString().slice(7);
            // const invoice= "INV:"+uuidv4().substr(0,7);
            this.invoice_number = invoice;
        },
        vendorName() {
            axios.get(this.url + "users").then((res) => {
                const userlist = res.data.data;
                const filteredUsers = userlist.filter((user) => user.role_id === 3);
                this.vendorList = filteredUsers;
            });
        },
        createPurchases() {
            const alldata = {
                invoice_number: this.invoice_number,
                date: this.date,
                user_id: this.user_id,
                purchases: this.items
            };
            console.log(alldata);
            axios.post(this.url+ "purchases",alldata)
            .then((res)=>{
                this.$router.push({ name: 'purchaseslist' });
            })
        },
        calculatePrice(item,event) {
            const selectedProduct = this.products.find(product => product.id === item.product_id);
            const valueOfQuantity=(event.target.value);
            if(valueOfQuantity < 1){
                    alert("O Hello! You can not use nagetive value!!");
                    if(item.quantity<1){
                        item.quantity=1;
                    };
                    if(item.price<1){
                        item.price=selectedProduct.price;
                    };
                    }
            if (selectedProduct && item.quantity) {
                const totalPrice = (selectedProduct.price * item.quantity).toFixed(2);
                const totalPriceq = (item.price * item.quantity);
                item.totalPrice = totalPrice;
                item.totalPrice = totalPriceq;
                this.getTotalPrice()
            }
        },
        // ===============Generate grandTotal as the all total price sum======================
        getTotalPrice() {
            this.grandTotal=0;
            const p = this.items;
            for (let i = 0; i < p.length; i++) {
            const tprice=parseInt((p[i].totalPrice));
            this.grandTotal+=tprice;
            }    
    },
    },
    mounted() {
        this.invoiceNum();
        this.vendorName();
        this.getProducts();
    },
}
</script>

<template>
    <div>
        <div class="container-xxl flex-grow-1 container-p-y text-dark">
            <div class="col-md-12 row">
                <div class="col-md-4 ">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Add a New Purcheses </h4>
                </div>
                <div class="col-md-3 "></div>
                <div class="col-md-5 ">
                    <router-link :to="{ name: 'purchaseslist' }" class="btn btn-outline-danger">Discard</router-link>
                    <button class="btn btn-dark ml-2"> Save Draft</button>
                    <button class="btn btn-primary ml-2"> Publish Purcheses</button>
                </div>
            </div>
            <!-- Basic Layout -->
            <div class="row">
                <div class="container">
                    <div class="card">
                        <div class="card-body p-0">
                            <form @submit.prevent="createPurchases()">
                                <div class="card-body">
                                    <div class="card-body">
                                        <strong style="color: red"></strong>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group row">
                                                    <label for>Invioce Number</label>
                                                    <div>
                                                        <input type="text" class="form-control"
                                                            placeholder="Invioce Number" v-model="invoice_number"
                                                            readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group row">
                                                    <label>Vendor Name</label>
                                                    <div>
                                                        <select class="form-control" v-model="user_id">
                                                            <option value>Select Vendor Name</option>
                                                            <option v-for="(vdata, i) in vendorList" :key="i"
                                                                :value="vdata.id">
                                                                {{ vdata.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group row">
                                                    <label>Select Product</label>
                                                    <input type="text" class="form-control" @change="addProduct($event)"
                                                        list="product-list" placeholder="Select Products">
                                                    <datalist id="product-list">
                                                        <option v-for="(product, index) in products" :key="index"
                                                            :value="product.id">
                                                            {{ product.name }}
                                                        </option>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group row">
                                                    <label>Added Date</label>
                                                    <div>
                                                        <input type="datetime-local" class="form-control"
                                                            v-model="date" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
 <!-- ==========================add item start============================================= -->
                                        <hr />
                                        <div v-for="(item, index) in items" :key="index">
                                            <div class="row mt-3">
                                                <div class="col-md-3">
                                                    <label v-if="index == 0" class="form-label">Product</label>
                                                    <input class="form-control" type="text" v-model="item.product_name"
                                                        readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label v-if="index == 0" class="form-label">Unit</label>
                                                    <input type="text" class="form-control" v-model="item.unit">
                                                </div>
                                                <div class="col-md-2">
                                                    <label v-if="index == 0" class="form-label">Quantity</label>
                                                    <input type="number" class="form-control" v-model="item.quantity"
                                                        @input="calculatePrice(item,$event)" min="1">
                                                </div>
                                                <div class="col-md-2">
                                                    <label v-if="index == 0" class="form-label">Per Price</label>
                                                    <input type="number" class="form-control" v-model="item.price"
                                                    @input="calculatePrice(item,$event)">
                                                </div>
                                                <div class="col-md-2">
                                                    <label v-if="index == 0" class="form-label">Total Price</label>
                                                    <input type="number" class="form-control" v-model="item.totalPrice"
                                                        readonly>
                                                </div>
                                                <div :class="'col-md-1 ' + (index === 0 ? 'mt-4' : '')">
                                                    <button @click="removeItem(index)" class="btn btn-danger">⛔</button>
                                                </div>
                                            </div>
                                        </div>
<!-- ==========================add item end============================================= -->
                                        <hr />
                                        <div class="d-flex justify-content-end mt-3"> 
                                            <div class="col-md-2" >
                                                    <label class="form-label">Grand Total </label>
                                                    <input type="number" class="form-control" v-model="grandTotal"
                                                        readonly>
                                                </div>
                                            </div>
                                        <div class="row">
                                            <div class="col-8"></div>
                                            <div class="col-4"></div>
                                        </div>
                                        <button type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>