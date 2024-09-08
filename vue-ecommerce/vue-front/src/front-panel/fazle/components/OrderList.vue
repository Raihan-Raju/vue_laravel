<script>
import axios from "axios";
import { mapGetters } from 'vuex';
import html2pdf from 'html2pdf.js';
import Modal from '../components/Modal.vue';

export default {
    name: "CustomerOrderList",
    data() {
        return {
            orders: [],
            showModal: false,
            selectedOrder: [],
            showModal2: false,
            shipmentStatus: ''
        }
    },
    methods: {
        getOrders() {
            axios.post(this.url + 'admin/customerorders', { id: this.user.id })
                .then((result) => {
                    this.orders = result.data.data;
                    console.log(result.data.data);
                })
        },
        closeModal() {
            this.showModal = false;
        },
        sModal() {
            this.showModal = true;
        },

        viewOrderDetails(orderId) {
            this.selectedOrder = this.findOrderById(this.orders, orderId);
            this.shipmentStatus = this.selectedOrder.shipment ? this.selectedOrder.shipment.status : 'no data';
        },

        findOrderById(orders, id) {
            return orders.find(order => order.id === id);
        },

        printInvoice() {
            const printContents = document.getElementById('invoice2').innerHTML;
            const originalContents = document.body.innerHTML;
            const newWindow = window.open('', '', 'height=500, width=800');
            newWindow.document.write('<html><head><title>Invoice</title>');
            newWindow.document.write('</head><body>');
            newWindow.document.write(printContents);
            newWindow.document.write('</body></html>');
            newWindow.document.close();
            newWindow.print();
            newWindow.close();
        },
        exportPDF() {
            const element = document.getElementById('invoice2');
            const options = {
                margin: 1,
                filename: `Invoice_${this.selectedOrder.id}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(element).set(options).save();
        },
        getStepColor(step) {
            const steps = ['processing', 'shipped', 'route', 'delivered'];
            const activeIndex = steps.indexOf(this.shipmentStatus);
            const stepIndex = steps.indexOf(step);

            return stepIndex <= activeIndex ? 'active-color' : 'inactive-color';
        }

    },
    computed: {
        ...mapGetters('auth', {
            user: 'user',
        }),
        ...mapGetters(['url']),

        activeSteps() {
            const steps = ['processing', 'shipped', 'route', 'delivered'];
            const activeIndex = steps.indexOf(this.shipmentStatus);
            return steps.map((step, index) => {
                return index <= activeIndex ? 'active step0' : 'step0';
            });

        }, 
    },
    mounted() {
        this.getOrders();
    },
    components: {
        Modal
    },
}
</script>

<template>
    <div>
        <h3 class="d-flex align-items-center mb-3">Order List</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Total Price (tk)</th>
                    <th scope="col">Date</th>
                    <th scope="col">Payment</th>
                    <th scope="col">Shipping</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(o, i) in orders" :key="i">
                    <th scope="row">{{ ++i }}</th>
                    <td>{{ o.id }}</td>
                    <td>{{ o.total_price }}</td>
                    <td>{{ o.order_date }}</td>
                    <td>Status: {{ o.payment ? o.payment.status : 'no data' }}, Method: {{ o.payment ? o.payment.method
                        : 'no data' }}</td>
                    <td>Status: {{ o.shipment ? o.shipment.status : 'no data' }}</td>
                    <td>
                        <button class="btn btn-danger">Request Cancellation</button>
                        <button @click="sModal(), viewOrderDetails(o.id)" class="btn btn-info mt-1">View
                            Invoice</button>
                        <button @click="showModal2 = true, viewOrderDetails(o.id)"
                            class="btn btn-primary mt-1 ml-1">Track Order</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- modal starts here -->
        <div>
            <div>
                <div v-if="showModal" class="modal-backdrop">
                    <div class="modal-dialog-centered" style="height: 80%; overflow: scroll; margin-top: 60px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Invoice</h5>
                                <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="invoice">
                                    <div class="toolbar hidden-print">
                                        <div class="text-end">
                                            <button type="button" class="btn btn-dark mr-1" @click="printInvoice"><i
                                                    class="fa fa-print"></i> Print</button>
                                            <button type="button" class="btn btn-info" @click="exportPDF"><i
                                                    class="fa fa-file-pdf-o"></i> Export as PDF</button>
                                            <button type="button" class="btn btn-danger ml-1" @click="closeModal"><i
                                                    class="fa fa-times"></i>
                                                Close</button>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="invoice overflow-auto" id="invoice2">
                                        <div style="min-width: 600px">
                                            <header>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="javascript:;">
                                                            <img :src="`http://127.0.0.1:8000/photos/users/${user.photo ? user.photo.path : 'no-image.jpg'}`"
                                                                width="80" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="col company-details">
                                                        <h2 class="name">
                                                            <a target="_blank" href="javascript:;">
                                                                V-Commerce
                                                            </a>
                                                        </h2>
                                                        <div>455 Foggy Heights, AZ 85004, US</div>
                                                        <div>(123) 456-789</div>
                                                        <div>vcommerce@vue.com</div>
                                                    </div>
                                                </div>
                                            </header>
                                            <main>
                                                <div class="row contacts">
                                                    <div class="col invoice-to">
                                                        <div class="text-gray-light">INVOICE TO:</div>
                                                        <h2 class="to">{{ user.name }}</h2>
                                                        <div class="address">{{ user.address }}</div>
                                                        <div class="email"><a href="mailto:john@example.com">{{
                                                            user.email }}</a>
                                                        </div>
                                                    </div>
                                                    <div class="col invoice-details">
                                                        <h1 class="invoice-id">INVOICE 3-2-1</h1>
                                                        <div class="date">Date of Invoice: 01/10/2018</div>
                                                        <div class="date">Due Date: 30/10/2018</div>
                                                    </div>
                                                </div>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th class="text-left">Product Name</th>
                                                            <th class="text-right">Unit Price</th>
                                                            <th class="text-right">Quantity</th>
                                                            <th class="text-right">Total Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(p, i) in selectedOrder.order_items" :key="i">
                                                            <td class="no">{{ ++i }}</td>
                                                            <td class="text-left">
                                                                <h3>
                                                                    <a target="_blank" href="javascript:;">
                                                                        {{ p.product.name }}
                                                                    </a>
                                                                </h3>
                                                                <a target="_blank" href="javascript:;">
                                                                    {{ p.product.description }}
                                                                </a>
                                                            </td>
                                                            <td class="unit">{{ p.product.price }}</td>
                                                            <td class="qty">{{ p.quantity }}</td>
                                                            <td class="total">{{ p.product.price * p.quantity }}</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">SUBTOTAL</td>
                                                            <td>{{ selectedOrder.total_price }} ৳</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">TAX 25%</td>
                                                            <td>{{ selectedOrder.total_price * 0.25 }} ৳</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="2">GRAND TOTAL</td>
                                                            <td>{{ selectedOrder.total_price * 1.25 }} ৳</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="thanks">Thank you!</div>
                                                <div class="notices">
                                                    <div>NOTICE:</div>
                                                    <div class="notice">A finance charge of 1.5% will be made on unpaid
                                                        balances after 30 days.</div>
                                                </div>
                                            </main>
                                            <footer>Invoice was created on a computer and is valid without the signature
                                                and seal.</footer>
                                        </div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modala starts here -->
        <div>
            <button @click="showModal2 = true" class="btn btn-primary">Open Modal</button>

            <Modal :title="'Order Tracker'" :isVisible="showModal2" @close="showModal2 = false">
                <div class="container">
                    <div class="card">
                        <div class="row d-flex justify-content-between px-3 top">
                            <div class="d-flex">
                                <h5>ORDER <span class="text-primary font-weight-bold">#Y34XDHR</span></h5>
                            </div>
                            <div class="d-flex flex-column text-sm-right">
                                <p class="mb-0">Expected Arrival <span>01/12/19</span></p>
                                <p>USPS <span class="font-weight-bold">234094567242423422898</span></p>
                            </div>
                        </div>
                        <!-- Add class 'active' to progress -->
                        <div class="row d-flex justify-content-center">
                            <div class="col-12">
                                <ul id="progressbar" class="text-center">
                                    <li :class="activeSteps[0]">Processed</li>
                                    <li :class="activeSteps[1]">Shipped</li>
                                    <li :class="activeSteps[2]">On Route</li>
                                    <li :class="activeSteps[3]">Arrived</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row justify-content-between top">
                            <div class="row d-flex icon-content">
                                <img :class="[getStepColor('processing') === 'active-color' ? 'active-icon' : 'inactive-icon']"
                                    class="icon" src="https://i.imgur.com/9nnc9Et.png">
                                <div :class="getStepColor('processing')" class="d-flex flex-column">
                                    <p class="font-weight-bold">Order<br>Processed</p>
                                </div>
                            </div>
                            <div class="row d-flex icon-content">
                                <img :class="[getStepColor('shipped') === 'active-color' ? 'active-icon' : 'inactive-icon']"
                                    class="icon" src="https://i.imgur.com/u1AzR7w.png">
                                <div :class="getStepColor('shipped')" class="d-flex flex-column">
                                    <p class="font-weight-bold">Order<br>Shipped</p>
                                </div>
                            </div>
                            <div class="row d-flex icon-content">
                                <img :class="[getStepColor('route') === 'active-color' ? 'active-icon' : 'inactive-icon']"
                                    class="icon" src="https://i.imgur.com/TkPm63y.png">
                                <div :class="getStepColor('route')" class="d-flex flex-column">
                                    <p class="font-weight-bold">Order<br>En Route</p>
                                </div>
                            </div>
                            <div class="row d-flex icon-content">
                                <img :class="[getStepColor('delivered') === 'active-color' ? 'active-icon' : 'inactive-icon']"
                                    class="icon" src="https://i.imgur.com/HdsziHP.png">
                                <div :class="getStepColor('delivered')" class="d-flex flex-column">
                                    <p class="font-weight-bold">Order<br>Arrived</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </Modal>
        </div>
        <!-- modal ends here -->

    </div>

</template>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
}

.modal-dialog-centered {
    width: 100%;
    max-width: 800px;
    background: white;
    padding: 20px;
    border-radius: 5px;
}

.modal-content {
    background: white;
}

.btn-close {
    background: none;
    border: none;
    font-size: 1.5rem;
}

body {
    margin-top: 20px;
    background-color: #f7f7ff;
}

#invoice {
    padding: 0px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #0d6efd
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #0d6efd
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #0d6efd;
    background: #e7f2ff;
    padding: 10px;
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,
.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #0d6efd;
    font-size: 1.2em
}

.invoice table .qty,
.invoice table .total,
.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #0d6efd
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #0d6efd;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0px solid rgba(0, 0, 0, 0);
    border-radius: .25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
}

.invoice table tfoot tr:last-child td {
    color: #0d6efd;
    font-size: 1.4em;
    border-top: 1px solid #0d6efd
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px !important;
        overflow: hidden !important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #0d6efd;
    background: #e7f2ff;
    padding: 10px;
}


/* modal css */
body {
    color: #000;
    overflow-x: hidden;
    height: 100%;
    background-color: #8C9EFF;
    background-repeat: no-repeat;
}

.card {
    z-index: 0;
    background-color: #ECEFF1;
    padding-bottom: 20px;
    margin-top: 0px;
    margin-bottom: 90px;
    border-radius: 10px;
}

.top {
    padding-top: 40px;
    padding-left: 13% !important;
    padding-right: 13% !important;
}

/*Icon progressbar*/
#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: #455A64;
    padding-left: 0px;
    margin-top: 30px;
}

#progressbar li {
    list-style-type: none;
    font-size: 13px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400;
}

#progressbar .step0:before {
    font-family: FontAwesome;
    content: "\f10c";
    color: #fff;
}

#progressbar li:before {
    width: 40px;
    height: 40px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    background: #C5CAE9;
    border-radius: 50%;
    margin: auto;
    padding: 0px;
}

/*ProgressBar connectors*/
#progressbar li:after {
    content: '';
    width: 100%;
    height: 12px;
    background: #C5CAE9;
    position: absolute;
    left: 0;
    top: 16px;
    z-index: -1;
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    position: absolute;
    left: -50%;
}

#progressbar li:nth-child(2):after,
#progressbar li:nth-child(3):after {
    left: -50%;
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    position: absolute;
    left: 50%;
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

/*Color number of the step and the connector before it*/
#progressbar li.active:before,
#progressbar li.active:after {
    background: #651FFF;
}

#progressbar li.active:before {
    font-family: FontAwesome;
    content: "\f00c";
}

.icon {
    width: 60px;
    height: 60px;
    margin-right: 15px;
}

.icon-content {
    padding-bottom: 20px;
}

@media screen and (max-width: 992px) {
    .icon-content {
        width: 50%;
    }
}

/* active color */
.active-color {
    color: #651FFF;
}

.inactive-color {
    color: #C5CAE9;
}

.active-icon {
    filter: grayscale(0);
}

.inactive-icon {
    filter: grayscale(100%);
}
</style>