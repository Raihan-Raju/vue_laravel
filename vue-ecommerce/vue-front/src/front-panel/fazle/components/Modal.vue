<template>
    <div class="modal-backdrop" v-if="isVisible">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ title }}</h5>
          <button type="button" class="close" @click="closeModal">&times;</button>
        </div>
        <div class="modal-body" style="height: 470px;">
          <slot></slot>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" @click="closeModal">Close</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Modal',
    props: {
      title: {
        type: String,
        required: true
      },
      isVisible: {
        type: Boolean,
        required: true
      }
    },
    methods: {
      closeModal() {
        this.$emit('close');
      }
    }
  }
  </script>
  
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
  }
  
  .modal-content {
    background: white;
    padding: 20px;
    border-radius: 5px;
    width: 500px;
    max-width: 100%;
  }
  
  .modal-header,
  .modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .modal-title {
    margin: 0;
  }
  
  .close {
    background: none;
    border: none;
    font-size: 1.5rem;
  }
  </style>
  