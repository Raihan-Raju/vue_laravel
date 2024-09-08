<template>
    <div>
        <button @click="showModal = true" class="btn btn-primary">Open Modal</button>

        <Modal :title="'My Modal Title'" :isVisible="showModal" @close="showModal = false">
            <p>This is the content of the modal.</p>
        </Modal>
    </div>
</template>

<script>
import Modal from '../components/Modal.vue';

export default {
    components: {
        Modal
    },
    data() {
        return {
            showModal: false
        };
    }
}
</script>

<style>
.btn-primary {
    padding: 10px 20px;
    background-color: #007bff;
    border: none;
    color: white;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>